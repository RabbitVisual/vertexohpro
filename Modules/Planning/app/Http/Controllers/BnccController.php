<?php

namespace Modules\Planning\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Planning\Services\MagicPlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BnccController extends Controller
{
    protected $magicPlanService;

    public function __construct(MagicPlanService $magicPlanService)
    {
        $this->magicPlanService = $magicPlanService;
    }

    /**
     * Search for BNCC skills with caching (Autocomplete).
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
            return DB::table('bncc_habilidades')
                ->where('codigo', 'like', "%{$query}%") // Migration uses 'codigo' not 'code'
                ->orWhere('descricao', 'like', "%{$query}%")
                ->limit(20)
                ->get();
        });

        return response()->json($skills);
    }

    /**
     * Get specific skill details by code.
     *
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $code)
    {
        $skillData = $this->magicPlanService->getSkillByCode($code);

        if (!$skillData) {
            return response()->json(['message' => 'Skill not found'], 404);
        }

        return response()->json($skillData);
    }

    public function index()
    {
        // Just return view if needed, or API
        return view('planning::bncc.index');
    }
}
