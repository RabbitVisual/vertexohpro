<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Library\Models\LibraryResource;
use Modules\Library\Models\ResourceRating;
use Modules\Library\Services\DownloadService;

class LibraryResourceController extends Controller
{
    protected $downloadService;

    public function __construct(DownloadService $downloadService)
    {
        $this->downloadService = $downloadService;
    }

    public function index(Request $request)
    {
        // For UI compatibility with Jules visual foundation
        if ($request->wantsJson()) {
            $query = LibraryResource::query();

            if ($request->has('search')) {
                $term = $request->search;
                $query->where(function($q) use ($term) {
                    $q->where('title', 'like', "%{$term}%")
                      ->orWhere('description', 'like', "%{$term}%");
                });
            }

            return response()->json($query->paginate(20));
        }

        return view('library::materials.index');
    }

    public function show($id)
    {
        $resource = LibraryResource::with(['author:id,first_name,last_name,photo', 'ratings.user:id,first_name,last_name,photo'])
            ->findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($resource);
        }

        return view('library::resources.show', compact('resource'));
    }

    public function getDownloadLink(Request $request, $id)
    {
        $resource = LibraryResource::findOrFail($id);
        $user = $request->user();

        try {
            $url = $this->downloadService->getDownloadUrl($resource, $user);
            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function download(Request $request, $resourceId, $userId)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid signature');
        }

        $resource = LibraryResource::findOrFail($resourceId);
        return $this->downloadService->streamDownload($resource);
    }

    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $user = $request->user();
        $resource = LibraryResource::findOrFail($id);

        if (!$this->downloadService->hasPermission($resource, $user)) {
            return response()->json(['error' => 'You must purchase this material to rate it.'], 403);
        }

        $rating = ResourceRating::updateOrCreate(
            ['user_id' => $user->id, 'library_resource_id' => $resource->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return response()->json(['message' => 'Rating submitted successfully.', 'data' => $rating]);
    }
}
