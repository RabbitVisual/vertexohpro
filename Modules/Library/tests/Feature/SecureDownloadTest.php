<?php

namespace Modules\Library\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\Library\Models\LibraryResource;
use Modules\Billing\Models\MaterialPurchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class SecureDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_purchaser_can_generate_download_link()
    {
        Storage::fake('private');
        $author = User::factory()->create();
        $buyer = User::factory()->create();

        $resource = LibraryResource::create([
            'user_id' => $author->id,
            'title' => 'Protected File',
            'file_path' => 'protected.pdf',
            'price' => 20.00,
            'status' => 'approved',
        ]);
        Storage::disk('private')->put('protected.pdf', 'content');

        MaterialPurchase::create([
            'user_id' => $buyer->id,
            'library_resource_id' => $resource->id,
            'amount' => 20.00,
        ]);

        $response = $this->actingAs($buyer)
             ->get(route('library.download', $resource->id));

        $response->assertStatus(302); // Redirects to signed URL
        $this->assertStringContainsString('library/stream', $response->headers->get('Location'));
    }

    public function test_non_purchaser_cannot_download()
    {
        $author = User::factory()->create();
        $stranger = User::factory()->create();

        $resource = LibraryResource::create([
            'user_id' => $author->id,
            'title' => 'Protected File',
            'file_path' => 'protected.pdf',
            'price' => 20.00,
            'status' => 'approved',
        ]);

        $this->actingAs($stranger)
             ->get(route('library.download', $resource->id))
             ->assertStatus(403);
    }
}
