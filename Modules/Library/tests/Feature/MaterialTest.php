<?php

namespace Modules\Library\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\Library\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class MaterialTest extends TestCase
{
    // use RefreshDatabase; // Commented out to avoid wiping db if env not set up for testing

    public function test_can_instantiate_material()
    {
        $material = new Material();
        $this->assertInstanceOf(Material::class, $material);
    }
}
