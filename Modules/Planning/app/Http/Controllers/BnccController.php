<?php

namespace Modules\Planning\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Planning\Services\MagicPlanService;
use Illuminate\Http\Request;

class BnccController extends Controller
{
    protected $magicPlanService;

    public function __construct(MagicPlanService $magicPlanService)
    {
        $this->magicPlanService = $magicPlanService;
    }

    /**
     * Search for a BNCC skill by code.
     *
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(string $code)
    {
        $skillData = $this->magicPlanService->getSkillByCode($code);

        if (!$skillData) {
            return response()->json(['message' => 'Skill not found'], 404);
        }

        return response()->json($skillData);
    }
}
