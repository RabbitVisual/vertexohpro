<?php

namespace Modules\Library\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\Library\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LibraryModuleTest extends TestCase
{
    // use RefreshDatabase; // Disabled to preserve environment

    public function test_can_instantiate_material()
    {
        $material = new Material();
        $this->assertInstanceOf(Material::class, $material);
    }

    public function test_material_routes_exist()
    {
        // Routes are prefixed with api. due to RouteServiceProvider or grouping logic
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('api.materials.index'));
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('api.library.index'));
    }
}
