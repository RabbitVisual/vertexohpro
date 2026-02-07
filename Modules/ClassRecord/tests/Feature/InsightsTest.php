<?php

namespace Modules\ClassRecord\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Models\Grade;
use Modules\ClassRecord\Jobs\SendReportCardJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class InsightsTest extends TestCase
{
    use RefreshDatabase;

    public function test_difficulty_map_data()
    {
        $schoolClass = SchoolClass::create(['name' => 'Insights Class']);
        $student = Student::create(['name' => 'S1', 'school_class_id' => $schoolClass->id]);

        Grade::create(['student_id' => $student->id, 'subject' => 'Math', 'score' => 4.5, 'bncc_skill_code' => 'EF06MA01']);
        Grade::create(['student_id' => $student->id, 'subject' => 'Math', 'score' => 8.5, 'bncc_skill_code' => 'EF06MA02']);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('classrecord.insights.difficulty_map', $schoolClass->id));

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertContains('EF06MA01', $data['labels']);
        $this->assertContains(4.5, $data['data']);
        $this->assertContains(8.5, $data['data']);
    }

    public function test_email_report_card_dispatches_job()
    {
        Queue::fake();

        $schoolClass = SchoolClass::create(['name' => 'Email Class']);
        $student = Student::create(['name' => 'S2', 'school_class_id' => $schoolClass->id, 'email' => 'student@test.com']);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('classrecord.email_report', $student->id));

        $response->assertRedirect();
        Queue::assertPushed(SendReportCardJob::class);
    }

    public function test_multi_stage_class_persistence()
    {
        $class = SchoolClass::create([
            'name' => 'Multi Stage Class',
            'is_multigrade' => true,
            'grades_covered' => ['4º Ano', '5º Ano']
        ]);

        $this->assertTrue($class->is_multigrade);
        $this->assertIsArray($class->grades_covered);
        $this->assertContains('4º Ano', $class->grades_covered);
    }
}
