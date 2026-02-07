<?php

namespace Modules\Planning\Services;

use Modules\Planning\Models\LessonPlan;
use Illuminate\Support\Collection;

class PdfExportService
{
    public function exportBatch(array $planIds)
    {
        $plans = LessonPlan::whereIn('id', $planIds)->with('schoolClass')->get();

        if ($plans->isEmpty()) {
            throw new \Exception("Nenhum plano selecionado.");
        }

        // Return a view that is styled for printing
        return view('planning::lesson-plans.export-pdf', compact('plans'));
    }
}
