<?php

namespace Modules\Planning\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Planning\Models\LessonPlan;
use Modules\Planning\Services\PdfExportService;
use Illuminate\Http\Request;

class LessonPlanController extends Controller
{
    protected $pdfService;

    public function __construct(PdfExportService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LessonPlan::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sections' => 'nullable|array',
        ]);

        return LessonPlan::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return LessonPlan::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'sections' => 'nullable|array',
        ]);

        $lessonPlan->update($validated);

        return $lessonPlan;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);
        $lessonPlan->delete();

        return response()->noContent();
    }

    /**
     * Duplicate an existing lesson plan.
     *
     * @param string $id
     * @return LessonPlan
     */
    public function duplicate(string $id)
    {
        $original = LessonPlan::findOrFail($id);

        $newPlan = $original->replicate();
        $newPlan->title = $original->title . ' (Cópia)';
        $newPlan->save();

        return $newPlan;
    }

    /**
     * Export the lesson plan to PDF.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function export(string $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);
        $pdf = $this->pdfService->export($lessonPlan);

        return $pdf->download("plano_aula_{$lessonPlan->id}.pdf");
    }
}
