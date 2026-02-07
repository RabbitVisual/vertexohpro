<?php

namespace Modules\Core\Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Modules\Core\Livewire\CommandPalette;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommandPaletteTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_palette_renders()
    {
        Livewire::test(CommandPalette::class)
            ->assertStatus(200);
    }

    public function test_search_functionality()
    {
        // We test with a term that hits the static navigation items to avoid DB dependency issues across modules
        Livewire::test(CommandPalette::class)
            ->set('query', 'Diário')
            ->assertSee('Diário de Classe');

        Livewire::test(CommandPalette::class)
            ->set('query', 'Dashboard')
            ->assertSee('Dashboard');
    }
}
