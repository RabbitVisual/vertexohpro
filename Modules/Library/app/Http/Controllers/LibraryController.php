<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Library\Models\LibraryResource;
use Modules\Library\Services\DownloadService;
use Modules\Library\Services\ImageOptimizerService;
use Modules\Library\Services\WatermarkService;
use Modules\ClassRecord\Models\SchoolClass;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    protected $downloadService;
    protected $imageOptimizer;
    protected $watermarker;

    public function __construct(
        DownloadService $downloadService,
        ImageOptimizerService $imageOptimizer,
        WatermarkService $watermarker
    ) {
        $this->downloadService = $downloadService;
        $this->imageOptimizer = $imageOptimizer;
        $this->watermarker = $watermarker;
    }

    /**
     * Display a listing of the resource with recommendations.
     */
    public function index(Request $request)
    {
        $query = LibraryResource::with(['author', 'user']);
        $user = Auth::user();
        $userSubjects = [];

        // Recommendations based on profile (classes subjects)
        if ($user) {
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

        // Standard filtering
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        if ($request->filled('price')) {
            if ($request->price === 'free') {
                $query->where('price', 0);
            } elseif ($request->price === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        if ($request->filled('subject')) {
            $query->where('subject', $request->subject)
                  ->orWhereJsonContains('tags', $request->subject);
        }

        if ($request->filled('grade')) {
            $query->whereJsonContains('tags', $request->grade);
        }

        $resources = $query->latest()->paginate(12)->withQueryString();

        return view('library::index', compact('resources', 'userSubjects'));
    }

    /**
     * Display the authenticated user's purchased materials.
     */
    public function myLibrary(Request $request)
    {
        $user = $request->user();

        // Standardized to LibraryResource logic
        $purchased = LibraryResource::whereHas('purchases', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        $created = LibraryResource::where('user_id', $user->id)
            ->withCount('purchases')
            ->latest()
            ->get();

        return view('library::my-library', compact('purchased', 'created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $resource = LibraryResource::with(['author', 'user'])->findOrFail($id);

        $user = $request->user();
        $hasAccess = $this->downloadService->hasPermission($resource, $user);

        return view('library::show', compact('resource', 'hasAccess'));
    }

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

        $filePath = $request->file('file')->store('library/files', 'local');

        $previewPath = null;
        if ($request->hasFile('preview_image')) {
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

        if (!$this->downloadService->hasPermission($resource, $user)) {
             abort(403);
        }

        if (!Storage::disk('local')->exists($resource->file_path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        $originalPdfPath = Storage::disk('local')->path($resource->file_path);

        $watermarkText = $user->name;
        // In a real app, adding more identifiers like email/CPF would be better

        try {
            $pdfContent = $this->watermarker->apply($originalPdfPath, $watermarkText);

            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . basename($resource->file_path) . '"');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao gerar PDF: ' . $e->getMessage());
        }
    }
}
