<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Library\Models\Material;
use Modules\Library\Services\DownloadService;

class MaterialController extends Controller
{
    protected $downloadService;

    public function __construct(DownloadService $downloadService)
    {
        $this->downloadService = $downloadService;
    }

    public function index(Request $request)
    {
        $query = Material::query();

        if ($request->has('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        if ($request->has('tags')) {
            $tags = $request->tags;
            if (is_string($tags)) {
                $tags = explode(',', $tags);
            }
            if (is_array($tags)) {
                foreach ($tags as $tag) {
                    $query->whereJsonContains('tags', trim($tag));
                }
            }
        }

        if ($request->has('bncc')) {
            $bncc = $request->bncc;
            if (is_string($bncc)) {
                $bncc = explode(',', $bncc);
            }
            if (is_array($bncc)) {
                foreach ($bncc as $code) {
                    $query->whereJsonContains('bncc_codes', trim($code));
                }
            }
        }

        // Pagination
        return response()->json($query->paginate(20));
    }

    public function show($id)
    {
        $material = Material::with('author:id,first_name,last_name,photo') // Eager load minimal author info
            ->findOrFail($id);

        return response()->json($material);
    }

    public function getDownloadLink(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $user = $request->user();

        try {
            $url = $this->downloadService->getDownloadUrl($material, $user);
            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function download(Request $request, $materialId, $userId)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid signature');
        }

        $material = Material::findOrFail($materialId);

        // Check if file exists
        if (!Storage::exists($material->file_path)) {
             abort(404, 'File not found');
        }

        // Generate filename for download
        $extension = pathinfo($material->file_path, PATHINFO_EXTENSION);
        $filename = \Illuminate\Support\Str::slug($material->title) . '.' . $extension;

        return Storage::download($material->file_path, $filename);
    }
}
