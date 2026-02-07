<?php

namespace Modules\Planning\Services;

use Modules\Planning\Models\LessonPlan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;

class PdfExportService
{
    /**
     * Generate a PDF for the lesson plan.
     *
     * @param LessonPlan $lessonPlan
     * @return \Barryvdh\DomPDF\PDF
     */
    public function export(LessonPlan $lessonPlan)
    {
        $data = [
            'plan' => $lessonPlan,
            'title' => 'Plano de Aula - ' . $lessonPlan->title,
            'date' => now()->format('d/m/Y'),
        ];

        // Ensure the view exists, otherwise fall back to a simple string
        if (View::exists('planning::pdf.lesson-plan')) {
            $pdf = Pdf::loadView('planning::pdf.lesson-plan', $data);
        } else {
            $content = $lessonPlan->sections ?: ($lessonPlan->content ?: []);
            $html = "<h1>{$lessonPlan->title}</h1><p>Objectives: " . json_encode($content['objectives'] ?? []) . "</p>";
            $pdf = Pdf::loadHTML($html);
        }

        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    /**
     * Export multiple lesson plans (Batch).
     */
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
