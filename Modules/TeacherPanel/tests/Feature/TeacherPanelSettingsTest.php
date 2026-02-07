<?php

namespace Modules\TeacherPanel\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\TeacherPanel\Models\TeacherPanelSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherPanelSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_settings()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('teacherpanel.update_settings'), [
            'widget_order' => ['agenda-aulas', 'resumo-frequencia', 'atalhos-bncc']
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('teacher_panel_settings', [
            'user_id' => $user->id,
        ]);

        $setting = TeacherPanelSetting::where('user_id', $user->id)->first();
        $this->assertEquals(['agenda-aulas', 'resumo-frequencia', 'atalhos-bncc'], $setting->widget_order);
    }

    public function test_cannot_update_settings_with_invalid_widgets()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('teacherpanel.update_settings'), [
            'widget_order' => ['invalid-widget']
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['widget_order.0']);
    }
}
