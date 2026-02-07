<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\Grade;
use Modules\ClassRecord\Models\Student;

class GradeController extends Controller
{
    public function index()
    {
        return view('classrecord::grades.index');
    }

    public function store(Request $request, $studentId)
    {
        $student = Student::with('schoolClass')->findOrFail($studentId);

        if ($student->schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'cycle' => 'required|integer|min:1',
            'evaluation_number' => 'required|integer|min:1|max:3',
            'score' => 'required|numeric|min:0|max:10',
        ]);

        Grade::updateOrCreate(
            [
                'student_id' => $student->id,
                'class_id' => $student->class_id,
                'cycle' => $validated['cycle'],
                'evaluation_number' => $validated['evaluation_number'],
            ],
            [
                'score' => $validated['score'],
            ]
        );

        return redirect()->back()->with('success', 'Nota salva com sucesso!');
    }
}
