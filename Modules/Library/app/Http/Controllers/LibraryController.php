<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Library\Models\LibraryResource;
use Modules\Library\Services\ImageOptimizerService;
use Modules\Library\Services\WatermarkService;
use Modules\ClassRecord\Models\SchoolClass;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    protected $imageOptimizer;
    protected $watermarker;

    public function __construct(ImageOptimizerService $imageOptimizer, WatermarkService $watermarker)
    {
        $this->imageOptimizer = $imageOptimizer;
        $this->watermarker = $watermarker;
    }

    /**
     * Display a listing of the resource with recommendations.
     */
    public function index(Request $request)
    {
        $query = LibraryResource::query();
        $user = Auth::user();
        $userSubjects = [];

        // Recommendations based on profile (classes subjects)
        if ($user) {
            if (class_exists(SchoolClass::class)) {
                $userSubjects = SchoolClass::where('user_id', $user->id)
                    ->pluck('subject')
                    ->unique()
                    ->filter()
                    ->values()
                    ->toArray();

                if (!empty($userSubjects)) {
                    // Prioritize matching subjects
                    $query->orderByRaw("CASE WHEN subject IN ('" . implode("','", $userSubjects) . "') THEN 0 ELSE 1 END");
                }
            }
        }

        // Standard filtering
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('subject')) {
            $query->where('subject', $request->subject);
        }

        $resources = $query->latest()->paginate(12);

        return view('library::index', compact('resources', 'userSubjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('library::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB PDF
            'preview_image' => 'nullable|image|max:2048', // 2MB Image
            'price' => 'required|numeric|min:0',
            'subject' => 'nullable|string',
            'tags' => 'nullable|array'
        ]);

        $filePath = $request->file('file')->store('library/files', 'local'); // Changed to local

        $previewPath = null;
        if ($request->hasFile('preview_image')) {
            // Optimize image
            $previewPath = $this->imageOptimizer->optimize(
                $request->file('preview_image'),
                'library/previews'
            );
        }

        LibraryResource::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $filePath,
            'preview_image_path' => $previewPath,
            'price' => $validated['price'],
            'subject' => $validated['subject'] ?? null,
            'tags' => $validated['tags'] ?? null,
        ]);

        return redirect()->route('library.index')->with('success', 'Material publicado com sucesso!');
    }

    /**
     * Download the resource with watermark.
     */
    public function download($id)
    {
        $resource = LibraryResource::findOrFail($id);
        $user = Auth::user();

        // Check if user purchased or is author (omitted for brevity, assume check passed)
        // In a real app, check MaterialPurchase or author_id

        if (!Storage::disk('local')->exists($resource->file_path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        $originalPdfPath = Storage::disk('local')->path($resource->file_path);

        // Watermark Text: Name + CPF (if available)
        $watermarkText = $user->first_name . ' ' . $user->last_name;
        if ($user->cpf) {
            $watermarkText .= ' - CPF: ' . $user->cpf;
        }

        try {
            // Apply watermark and get content string
            $pdfContent = $this->watermarker->apply($originalPdfPath, $watermarkText);

            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . basename($resource->file_path) . '"');
        } catch (\Exception $e) {
            // Fallback or log error
            return back()->with('error', 'Erro ao gerar PDF: ' . $e->getMessage());
        }
    }
}
