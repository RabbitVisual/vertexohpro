<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Models\SchoolClass;

class StudentController extends Controller
{
    public function store(Request $request, $classId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $class = SchoolClass::where('user_id', auth()->id())->findOrFail($classId);

        $student = Student::create([
            'name' => $validated['name'],
            'class_id' => $class->id,
        ]);

        return redirect()->route('classrecords.show', $class->id)
            ->with('success', 'Student added successfully.');
    }

    public function destroy($id)
    {
        $student = Student::with('schoolClass')->findOrFail($id);

        if ($student->schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        $student->delete();

        return redirect()->back()->with('success', 'Student removed successfully.');
    }
}
