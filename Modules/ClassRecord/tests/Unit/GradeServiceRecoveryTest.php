<?php

namespace Modules\ClassRecord\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\ClassRecord\Services\GradeService;
use Modules\ClassRecord\Models\Grade;
use Modules\ClassRecord\Models\CycleRecovery;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Models\SchoolClass;
use App\Models\User;

class GradeServiceRecoveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculate_cycle_average_with_recovery()
    {
        // Setup
        $user = User::create([
            'first_name' => 'Teacher',
            'last_name' => 'Test',
            'email' => 'teacher@test.com',
            'password' => bcrypt('password')
        ]);

        $class = SchoolClass::create([
            'name' => 'Physics 101',
            'subject' => 'Physics',
            'year' => '2026',
            'user_id' => $user->id
        ]);
        $student = Student::create([
            'name' => 'John Doe',
            'class_id' => $class->id
        ]);

        // Original Grades (Average 4.0)
        Grade::create(['student_id' => $student->id, 'class_id' => $class->id, 'cycle' => 1, 'evaluation_number' => 1, 'score' => 3.0]);
        Grade::create(['student_id' => $student->id, 'class_id' => $class->id, 'cycle' => 1, 'evaluation_number' => 2, 'score' => 5.0]);
        Grade::create(['student_id' => $student->id, 'class_id' => $class->id, 'cycle' => 1, 'evaluation_number' => 3, 'score' => 4.0]);

        $service = new GradeService();
        $status = $service->getCycleStatus($student->id, $class->id, 1);

        $this->assertEquals(4.0, $status['average']);
        $this->assertTrue($status['needs_recovery']); // Average < 5.0
        $this->assertEquals(4.0, $status['final']);

        // Add Recovery
        CycleRecovery::create([
            'student_id' => $student->id,
            'class_id' => $class->id,
            'cycle' => 1,
            'score' => 6.0
        ]);

        $status = $service->getCycleStatus($student->id, $class->id, 1);

        $this->assertEquals(4.0, $status['average']);
        $this->assertEquals(6.0, $status['recovery']);
        $this->assertEquals(6.0, $status['final']); // Should be max(4.0, 6.0) -> 6.0
    }
}
