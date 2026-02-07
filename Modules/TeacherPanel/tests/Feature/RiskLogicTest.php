<?php

namespace Modules\TeacherPanel\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Models\Attendance;
use Modules\ClassRecord\Models\Grade;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RiskLogicTest extends TestCase
{
    use RefreshDatabase;

    public function test_students_at_risk_widget_data()
    {
        // 1. Setup Data
        $schoolClass = SchoolClass::create(['name' => 'Testing Risk Class']);

        // Student A: High grade (10), Good attendance (100%) -> NOT RISK
        $studentA = Student::create(['name' => 'Safe Student', 'school_class_id' => $schoolClass->id]);
        Grade::create(['student_id' => $studentA->id, 'subject' => 'Math', 'score' => 10.0]);
        Attendance::create(['student_id' => $studentA->id, 'school_class_id' => $schoolClass->id, 'date' => now(), 'status' => 'present']);

        // Student B: Low grade (4.0), Good attendance -> RISK (Grade)
        $studentB = Student::create(['name' => 'Grade Risk Student', 'school_class_id' => $schoolClass->id]);
        Grade::create(['student_id' => $studentB->id, 'subject' => 'Math', 'score' => 4.0]);
        Attendance::create(['student_id' => $studentB->id, 'school_class_id' => $schoolClass->id, 'date' => now(), 'status' => 'present']);

        // Student C: High grade (10), Bad attendance (0% present, 1 total) -> 100% absence -> RISK (Attendance)
        $studentC = Student::create(['name' => 'Attendance Risk Student', 'school_class_id' => $schoolClass->id]);
        Grade::create(['student_id' => $studentC->id, 'subject' => 'Math', 'score' => 10.0]);
        Attendance::create(['student_id' => $studentC->id, 'school_class_id' => $schoolClass->id, 'date' => now(), 'status' => 'absent']);

        // 2. Execute Request
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('teacherpanel.widgets.students_at_risk'));

        // 3. Verify Response
        $response->assertStatus(200);
        $data = $response->json();

        $this->assertCount(2, $data, 'Should list exactly 2 students at risk');

        // Check student B
        $riskB = collect($data)->firstWhere('name', 'Grade Risk Student');
        $this->assertTrue($riskB['is_risk_grade']);
        $this->assertFalse($riskB['is_risk_attendance']);

        // Check student C
        $riskC = collect($data)->firstWhere('name', 'Attendance Risk Student');
        $this->assertFalse($riskC['is_risk_grade']);
        $this->assertTrue($riskC['is_risk_attendance']);
    }

    public function test_notifications_poll()
    {
        $user = User::factory()->create();

        // Create answered ticket
        $ticket = \Modules\Support\Models\Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Test Ticket',
            'status' => 'answered',
            'last_reply_at' => now(),
        ]);

        // Check with old timestamp
        $response = $this->actingAs($user)->getJson(route('teacherpanel.notifications.check', [
            'last_check' => now()->subMinute()->toDateTimeString()
        ]));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertNotEmpty($data['notifications']);
        $this->assertEquals('support', $data['notifications'][0]['type']);
    }
}
