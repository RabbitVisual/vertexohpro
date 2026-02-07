<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Services\StudentImportService;

class StudentController extends Controller
{
    protected $importService;

    public function __construct(StudentImportService $importService)
    {
        $this->importService = $importService;
    }

    public function index()
    {
        return view('classrecord::students.index');
    }

    public function import()
    {
        $classes = SchoolClass::where('user_id', auth()->id())->get();
        return view('classrecord::students.import', compact('classes'));
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        try {
            $file = $request->file('file');
            $this->importService->import($file->getRealPath(), $request->school_class_id);

            return redirect()->route('classrecord.students.index')->with('success', 'Alunos importados com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro na importação: ' . $e->getMessage());
        }
    }
}
