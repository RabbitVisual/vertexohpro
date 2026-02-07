<?php

namespace Modules\ClassRecord\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\ClassRecord\Services\GradeService;
use Modules\ClassRecord\Models\Grade;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Models\SchoolClass;
use App\Models\User;

class GradeServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculate_cycle_average()
    {
        // Setup
        $user = User::create([
            'first_name' => 'Teacher',
            'last_name' => 'Test',
            'email' => 'teacher@test.com',
            'password' => bcrypt('password')
        ]);

        $class = SchoolClass::create([
            'name' => 'Turma A',
            'subject' => 'Math',
            'year' => '1',
            'user_id' => $user->id
        ]);
        $student = Student::create([
            'name' => 'John Doe',
            'class_id' => $class->id
        ]);

        // Create Grades
        Grade::create([
            'student_id' => $student->id,
            'class_id' => $class->id,
            'cycle' => 1,
            'evaluation_number' => 1,
            'score' => 8.0
        ]);
        Grade::create([
            'student_id' => $student->id,
            'class_id' => $class->id,
            'cycle' => 1,
            'evaluation_number' => 2,
            'score' => 9.0
        ]);
        Grade::create([
            'student_id' => $student->id,
            'class_id' => $class->id,
            'cycle' => 1,
            'evaluation_number' => 3,
            'score' => 10.0
        ]);

        // Service
        $service = new GradeService();
        $average = $service->calculateCycleAverage($student->id, $class->id, 1);

        // Assert
        $this->assertEquals(9.0, $average);
    }
}
