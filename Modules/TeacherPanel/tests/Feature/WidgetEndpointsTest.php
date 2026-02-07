<?php

namespace Modules\TeacherPanel\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WidgetEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_frequency_widget_endpoint()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('teacherpanel.widgets.frequency'));

        $response->assertStatus(200)
                 ->assertJsonStructure(['labels', 'data']);
    }

    public function test_agenda_widget_endpoint()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('teacherpanel.widgets.agenda'));

        $response->assertStatus(200)
                 ->assertJsonStructure([['time', 'class', 'subject']]);
    }

    public function test_bncc_widget_search_endpoint()
    {
        $user = User::factory()->create();

        // Test with search query
        $response = $this->actingAs($user)->getJson(route('teacherpanel.widgets.bncc', ['q' => 'EF06MA01']));

        $response->assertStatus(200)
                 ->assertJsonFragment(['code' => 'EF06MA01']);

        // Test empty
        $responseEmpty = $this->actingAs($user)->getJson(route('teacherpanel.widgets.bncc'));
        $responseEmpty->assertStatus(200)
                      ->assertJsonCount(0);
    }
}
