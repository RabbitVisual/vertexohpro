<?php

namespace Modules\Library\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\Library\Models\LibraryResource;
use Modules\Billing\Models\MaterialPurchase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_can_see_sales_stats()
    {
        $author = User::factory()->create();
        $buyer = User::factory()->create();

        $resource = LibraryResource::create([
            'user_id' => $author->id,
            'title' => 'Test Material',
            'file_path' => 'test.pdf',
            'price' => 50.00,
            'status' => 'approved',
        ]);

        MaterialPurchase::create([
            'user_id' => $buyer->id,
            'library_resource_id' => $resource->id,
            'amount' => 50.00,
        ]);

        $this->actingAs($author)
             ->get(route('author.dashboard'))
             ->assertStatus(200)
             ->assertSee('R$ 50,00') // Total Sales
             ->assertSee('R$ 45,00'); // Available Balance (90%)
    }
}
