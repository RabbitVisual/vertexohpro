<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\Student;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('schoolClass');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $students = $query->paginate(15);
        $classes = SchoolClass::all();

        return view('classrecord::students.index', compact('students', 'classes'));
    }

    public function create(Request $request)
    {
        $classId = $request->query('class_id');
        $classes = SchoolClass::where('user_id', auth()->id())->get();
        return view('classrecord::students.create', compact('classes', 'classId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'registration_number' => 'nullable|string|max:50',
        ]);

        Student::create($validated);

        return redirect()->route('school-classes.show', $validated['class_id'])->with('success', 'Estudante adicionado com sucesso!');
    }

    public function show($id)
    {
        $student = Student::with(['schoolClass', 'grades', 'attendances'])->findOrFail($id);

        if ($student->schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        return view('classrecord::students.show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::with('schoolClass')->findOrFail($id);

        if ($student->schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        $classes = SchoolClass::where('user_id', auth()->id())->get();
        return view('classrecord::students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        if ($student->schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'registration_number' => 'nullable|string|max:50',
        ]);

        $student->update($validated);

        return redirect()->route('students.show', $student->id)->with('success', 'Cadastro atualizado com sucesso!');
    }

    public function import()
    {
        $classes = SchoolClass::where('user_id', auth()->id())->get();
        return view('classrecord::students.import', compact('classes'));
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'file' => 'required|file|mimes:csv,txt,xlsx',
        ]);

        // Logic for importing students would go here
        // For now, let's just redirect back with a success message
        return redirect()->route('classrecord.students.index')->with('success', 'Importação concluída com sucesso (Simulação).');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        if ($student->schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        $classId = $student->class_id;
        $student->delete();

        return redirect()->route('school-classes.show', $classId)->with('success', 'Estudante removido com sucesso!');
    }
}
