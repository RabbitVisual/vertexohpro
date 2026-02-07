<?php

namespace Modules\ClassRecord\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\Student;
use App\Models\User;

class ClassRecordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_class()
    {
        $user = User::create([
            'first_name' => 'Teacher',
            'last_name' => 'Test',
            'email' => 'teacher@test.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($user)->post(route('classrecords.store'), [
            'name' => 'Physics 101',
            'subject' => 'Physics',
            'year' => '2026',
        ]);

        $response->assertRedirect(route('classrecords.index'));
        $this->assertDatabaseHas('classes', ['name' => 'Physics 101']);
    }

    public function test_can_add_student_to_class()
    {
        $user = User::create([
            'first_name' => 'Teacher',
            'last_name' => 'Test',
            'email' => 'teacher2@test.com',
            'password' => bcrypt('password')
        ]);

        $class = SchoolClass::create([
            'name' => 'Physics 101',
            'subject' => 'Physics',
            'year' => '2026',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post(route('classrecords.students.store', $class->id), [
            'name' => 'Jane Doe',
        ]);

        $response->assertRedirect(route('classrecords.show', $class->id));
        $this->assertDatabaseHas('students', ['name' => 'Jane Doe', 'class_id' => $class->id]);
    }

    public function test_can_add_grade()
    {
        $user = User::create([
            'first_name' => 'Teacher',
            'last_name' => 'Test',
            'email' => 'teacher3@test.com',
            'password' => bcrypt('password')
        ]);

        $class = SchoolClass::create([
            'name' => 'Physics 101',
            'subject' => 'Physics',
            'year' => '2026',
            'user_id' => $user->id,
        ]);
        $student = Student::create(['name' => 'Jane Doe', 'class_id' => $class->id]);

        $response = $this->actingAs($user)->post(route('students.grades.store', $student->id), [
            'cycle' => 1,
            'evaluation_number' => 1,
            'score' => 8.5,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('grades', [
            'student_id' => $student->id,
            'score' => 8.5,
        ]);
    }
}
