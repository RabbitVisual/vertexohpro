<?php

namespace Modules\Planning\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Planning\Models\LessonPlan;
use Modules\Planning\Services\LessonPlanService;
use Modules\Planning\Services\PdfExportService;

class LessonPlanController extends Controller
{
    protected $lessonPlanService;
    protected $pdfExportService;

    public function __construct(LessonPlanService $lessonPlanService, PdfExportService $pdfExportService)
    {
        $this->lessonPlanService = $lessonPlanService;
        $this->pdfExportService = $pdfExportService;
    }

    public function index()
    {
        $plans = LessonPlan::with('schoolClass')->latest()->paginate(10);
        return view('planning::lesson-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('planning::lesson-plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'school_class_id' => 'nullable|exists:school_classes,id',
            'content' => 'required|array',
            'template_type' => 'required|in:standard,innovative,synthetic',
            'bncc_skills' => 'nullable|array',
        ]);

        $validated['user_id'] = auth()->id() ?? 1; // Fallback for dev

        LessonPlan::create($validated);

        return redirect()->route('planning.lesson-plans.index')->with('success', 'Plano criado com sucesso.');
    }

    public function show($id)
    {
        $plan = LessonPlan::with('schoolClass')->findOrFail($id);
        return view('planning::lesson-plans.show', compact('plan'));
    }

    public function edit($id)
    {
        $plan = LessonPlan::findOrFail($id);
        return view('planning::lesson-plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'school_class_id' => 'nullable|exists:school_classes,id',
            'content' => 'required|array',
            'template_type' => 'required|in:standard,innovative,synthetic',
            'bncc_skills' => 'nullable|array',
        ]);

        $plan = LessonPlan::findOrFail($id);
        $plan->update($validated);

        return redirect()->route('planning.lesson-plans.index')->with('success', 'Plano atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $plan = LessonPlan::findOrFail($id);
        $plan->delete();
        return redirect()->route('planning.lesson-plans.index')->with('success', 'Plano removido.');
    }

    // Custom Actions

    public function launchClass(Request $request, $id)
    {
        try {
            $plan = LessonPlan::findOrFail($id);
            $date = $request->input('date');

            $this->lessonPlanService->launchClass($plan, $date);

            return back()->with('success', 'Aula lançada no diário com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function exportBatch(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            // For testing, maybe export all or check query param 'id'
            if ($request->has('id')) {
                $ids = [$request->input('id')];
            } else {
                 return back()->with('error', 'Selecione pelo menos um plano.');
            }
        }

        try {
            return $this->pdfExportService->exportBatch($ids);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
