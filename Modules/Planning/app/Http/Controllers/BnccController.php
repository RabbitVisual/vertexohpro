<?php

namespace Modules\Planning\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BnccController extends Controller
{
    /**
     * Search for BNCC skills with caching.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([]);
        }

        // Cache key based on query
        $cacheKey = 'bncc_search_' . md5($query);

        $skills = Cache::remember($cacheKey, 60 * 24, function () use ($query) { // Cache for 24 hours
            return DB::table('bncc_skills')
                ->where('code', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->limit(20)
                ->get();
        });

        return response()->json($skills);
    }

    public function index()
    {
        // Just return view if needed, or API
        return view('planning::bncc.index');
    }
}
