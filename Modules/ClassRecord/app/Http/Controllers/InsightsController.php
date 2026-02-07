<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\Grade;
use Illuminate\Support\Facades\DB;

class InsightsController extends Controller
{
    /**
     * Get difficulty map data for a specific class.
     */
    public function difficultyMap($classId)
    {
        // In a real app, authorize user access to classId

        $skillsPerformance = Grade::whereHas('student', function ($query) use ($classId) {
                $query->where('school_class_id', $classId);
            })
            ->whereNotNull('bncc_skill_code')
            ->select('bncc_skill_code', DB::raw('avg(score) as average_score'))
            ->groupBy('bncc_skill_code')
            ->orderBy('average_score', 'asc') // Lowest performance first
            ->get();

        return response()->json([
            'labels' => $skillsPerformance->pluck('bncc_skill_code'),
            'data' => $skillsPerformance->pluck('average_score')->map(fn($v) => round($v, 2)),
        ]);
    }
}
