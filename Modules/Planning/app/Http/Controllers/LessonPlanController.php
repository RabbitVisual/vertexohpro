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
        // Ideally return a view for the list, but keeping API behavior for now unless requested
        // Prompt focus is on CREATE view.
        if (request()->wantsJson()) {
            return LessonPlan::all();
        }
        return LessonPlan::all(); // Or view('planning::lesson-plans.index', ['plans' => ...])
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('planning::lesson-plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sections' => 'nullable|array',
            'sections.*.title' => 'required|string',
            'sections.*.content' => 'nullable|string',
        ]);

        // Transform array sections to keyed array if needed,
        // but the model casts to array, so structure [ {title, content}, ... ] is fine.
        // The View sends `sections[0][title]`, `sections[0][content]`.
        // This results in an array of arrays, which is valid JSON.

        $plan = LessonPlan::create($validated);

        if ($request->wantsJson()) {
            return $plan;
        }

        return redirect()->route('lesson-plans.show', $plan->id) // Or index
                         ->with('success', 'Plano de aula criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plan = LessonPlan::findOrFail($id);

        if (request()->wantsJson()) {
            return $plan;
        }

        // Return a view for showing the plan (not explicitly asked but good for flow)
        // Since I don't have the show view, I'll just return the model or redirect to PDF export?
        // Let's return the model for now to avoid error, or a simple view if I had time.
        // Prompt only asked for CREATE view.
        return $plan;
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

        if ($request->wantsJson()) {
            return $lessonPlan;
        }

        return back()->with('success', 'Plano atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);
        $lessonPlan->delete();

        if (request()->wantsJson()) {
            return response()->noContent();
        }

        return redirect()->route('lesson-plans.index')->with('success', 'Plano removido.');
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
