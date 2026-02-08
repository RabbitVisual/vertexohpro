<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Services\ClassExportService;

class SchoolClassController extends Controller
{
    protected $exportService;

    public function __construct(ClassExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function index()
    {
        $classes = SchoolClass::where('user_id', auth()->id())->get();
        return view('classrecord::index', compact('classes'));
    }

    public function create()
    {
        return view('classrecord::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'year' => 'required|string|max:50',
            'grade' => 'required|string|max:50',
            'is_multigrade' => 'nullable|boolean',
        ]);

        $class = SchoolClass::create([
            'name' => $validated['name'],
            'subject' => $validated['subject'],
            'year' => $validated['year'],
            'grade' => $validated['grade'],
            'is_multigrade' => $validated['is_multigrade'] ?? false,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('school-classes.index')->with('success', 'Turma criada com sucesso.');
    }

    public function show($id)
    {
        $class = SchoolClass::where('user_id', auth()->id())
            ->with(['students.grades', 'attendances'])
            ->findOrFail($id);

        return view('classrecord::show', compact('class'));
    }

    public function edit($id)
    {
        $class = SchoolClass::where('user_id', auth()->id())->findOrFail($id);
        return view('classrecord::edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $class = SchoolClass::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'year' => 'required|string|max:50',
            'grade' => 'required|string|max:50',
            'is_multigrade' => 'nullable|boolean',
        ]);

        $class->update([
            'name' => $validated['name'],
            'subject' => $validated['subject'],
            'year' => $validated['year'],
            'grade' => $validated['grade'],
            'is_multigrade' => $validated['is_multigrade'] ?? false,
        ]);

        return redirect()->route('school-classes.index')->with('success', 'Turma atualizada com sucesso.');
    }

    public function destroy($id)
    {
        $class = SchoolClass::where('user_id', auth()->id())->findOrFail($id);
        $class->delete();

        return redirect()->route('school-classes.index')->with('success', 'Turma removida com sucesso.');
    }

    public function export($id)
    {
        try {
            $content = $this->exportService->export($id);
            $filename = 'backup_turma_' . $id . '_' . date('Ymd_His') . '.csv';

            return response($content)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', "attachment; filename=\"$filename\"");
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao exportar: ' . $e->getMessage());
        }
    }
}
