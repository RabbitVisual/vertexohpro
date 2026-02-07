<?php

namespace Modules\TeacherPanel\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Models\Attendance;
use Modules\Library\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class NewWidgetsTest extends TestCase
{
    use RefreshDatabase;

    public function test_frequency_widget_data()
    {
        // Seed some data
        $schoolClass = SchoolClass::create(['name' => 'Testing Class']);
        $student = Student::create(['name' => 'Test Student', 'school_class_id' => $schoolClass->id]);

        // Create attendance for today and yesterday
        Attendance::create(['student_id' => $student->id, 'school_class_id' => $schoolClass->id, 'date' => Carbon::now()->format('Y-m-d'), 'status' => 'present']);
        Attendance::create(['student_id' => $student->id, 'school_class_id' => $schoolClass->id, 'date' => Carbon::yesterday()->format('Y-m-d'), 'status' => 'absent']);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('teacherpanel.widgets.frequency'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['labels', 'data']);

        // Check if data reflects the seeded attendance
        // Note: The logic groups by date.
        // Today: 1 present / 1 total = 100%
        // Yesterday: 0 present / 1 total = 0%

        $data = $response->json('data');
        // Since orderBy('date'), yesterday comes first.
        $this->assertContains(0, $data);
        $this->assertContains(100, $data);
    }

    public function test_marketplace_trends_widget_data()
    {
        // Seed materials
        Material::create(['title' => 'Top Material', 'downloads_count' => 100]);
        Material::create(['title' => 'Second Material', 'downloads_count' => 50]);
        Material::create(['title' => 'Low Material', 'downloads_count' => 5]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('teacherpanel.widgets.marketplace_trends'));

        $response->assertStatus(200);
        $response->assertJsonCount(3); // Should return 3 items

        // Verify order
        $data = $response->json();
        $this->assertEquals('Top Material', $data[0]['title']);
        $this->assertEquals('Second Material', $data[1]['title']);
        $this->assertEquals('Low Material', $data[2]['title']);
    }
}
