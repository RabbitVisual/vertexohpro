<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Library\Models\Material;
use Modules\Library\Services\DownloadService;

class LibraryController extends Controller
{
    protected $downloadService;

    public function __construct(DownloadService $downloadService)
    {
        $this->downloadService = $downloadService;
    }

    /**
     * Display the Marketplace (All Materials) with filters.
     */
    public function index(Request $request)
    {
        $query = Material::with('author', 'ratings');

        // Text Search
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        // Filter by Price
        if ($request->filled('price')) {
            if ($request->price === 'free') {
                $query->where('price', 0);
            } elseif ($request->price === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        // Filter by Tags (Subject/Grade)
        if ($request->filled('subject')) {
            $query->whereJsonContains('tags', $request->subject);
        }
        if ($request->filled('grade')) {
            $query->whereJsonContains('tags', $request->grade);
        }

        // Filter by BNCC Code
        if ($request->filled('bncc')) {
            $bncc = $request->bncc;
            // Support multiple codes if comma-separated
            $codes = explode(',', $bncc);
            foreach ($codes as $code) {
                $query->whereJsonContains('bncc_codes', trim($code));
            }
        }

        $materials = $query->latest()->paginate(12)->withQueryString();

        return view('library::index', compact('materials'));
    }

    /**
     * Display the authenticated user's purchased materials.
     */
    public function myLibrary(Request $request)
    {
        $user = $request->user();

        $purchased = $user->purchasedMaterials()
            ->wherePivot('status', 'approved')
            ->orderByPivot('purchased_at', 'desc')
            ->get();

        $created = $user->materials()
            ->with('ratings')
            ->withCount('purchasers')
            ->latest()
            ->get();

        return view('library::my-library', compact('purchased', 'created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $material = Material::with(['author', 'ratings.user'])
            ->findOrFail($id);

        $user = $request->user();
        $hasAccess = $this->downloadService->hasPermission($material, $user);

        return view('library::show', compact('material', 'hasAccess'));
    }
}
