<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\Planning\Models\LessonPlan;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->query('query', '');

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $results = [];

        // Students
        $students = Student::where('first_name', 'like', "%{$term}%")
            ->orWhere('last_name', 'like', "%{$term}%")
            ->limit(5)
            ->get();

        foreach ($students as $student) {
            $results[] = [
                'type' => 'student',
                'title' => $student->full_name,
                'subtitle' => 'Aluno',
                'url' => route('students.show', $student->id), // Ensure route exists or fallback
            ];
        }

        // Classes
        $classes = SchoolClass::where('name', 'like', "%{$term}%")
            ->limit(5)
            ->get();

        foreach ($classes as $class) {
            $results[] = [
                'type' => 'class',
                'title' => $class->name,
                'subtitle' => 'Turma',
                'url' => route('classes.show', $class->id), // Ensure route exists
            ];
        }

        // Lesson Plans
        $plans = LessonPlan::where('title', 'like', "%{$term}%")
            ->limit(5)
            ->get();

        foreach ($plans as $plan) {
            $results[] = [
                'type' => 'plan',
                'title' => $plan->title,
                'subtitle' => 'Plano de Aula',
                'url' => route('planning.show', $plan->id), // Ensure route exists
            ];
        }

        return response()->json($results);
    }
}
