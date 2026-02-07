<?php

namespace Modules\TeacherPanel\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\TeacherPanel\Models\TeacherPanelSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_quick_notes()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('teacherpanel.update_notes'), [
            'notes' => 'Buy milk and grade papers.'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('teacher_panel_settings', [
            'user_id' => $user->id,
            'notes' => 'Buy milk and grade papers.'
        ]);
    }

    public function test_notes_are_displayed_in_index()
    {
        $user = User::factory()->create();
        TeacherPanelSetting::create([
            'user_id' => $user->id,
            'widget_order' => [],
            'notes' => 'Existing note content'
        ]);

        $response = $this->actingAs($user)->get(route('teacherpanel.index'));

        $response->assertStatus(200);
        $response->assertViewHas('notes', 'Existing note content');
    }
}
