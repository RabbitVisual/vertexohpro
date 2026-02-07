<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Library\Models\Material;
use Modules\Library\Models\MaterialRating;
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
        $material = Material::with(['author:id,first_name,last_name,photo', 'ratings.user:id,first_name,last_name,photo'])
            ->findOrFail($id);

        // Append average_rating is handled by model logic
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

        // Serve using service
        return $this->downloadService->streamDownload($material);
    }

    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $user = $request->user();
        $material = Material::findOrFail($id);

        // Check if user has purchased and approved status
        if (!$this->downloadService->hasPermission($material, $user)) {
            return response()->json(['error' => 'You must purchase this material to rate it.'], 403);
        }

        // Update or create rating
        $rating = MaterialRating::updateOrCreate(
            ['user_id' => $user->id, 'material_id' => $material->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return response()->json(['message' => 'Rating submitted successfully.', 'data' => $rating]);
    }
}
