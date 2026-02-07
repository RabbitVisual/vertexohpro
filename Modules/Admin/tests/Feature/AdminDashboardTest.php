<?php

namespace Modules\Admin\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\Billing\Models\Subscription;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Define Spatie Migrations manually for testing environment
        if (!Schema::hasTable('roles')) {
            Schema::create('permission_tables', function (Blueprint $table) {
                $table->id();
            });
            // Run the actual migration file if possible, or define schema here
            $this->createSpatieTables();
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => 'admin']);
    }

    private function createSpatieTables()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');
        });

        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
        });
    }

    public function test_admin_can_access_dashboard()
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@vertex.com',
            'password' => bcrypt('password')
        ]);

        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Administrativo');
    }

    public function test_non_admin_cannot_access_dashboard()
    {
        $user = User::create([
            'first_name' => 'Regular',
            'last_name' => 'User',
            'email' => 'user@vertex.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_metrics_calculation()
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@vertex.com',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole('admin');

        // Create some users
        User::create([
            'first_name' => 'User1', 'last_name' => 'Test', 'email' => 'u1@test.com', 'password' => '123'
        ]);

        // Create subscriptions
        Subscription::create([
            'user_id' => $admin->id,
            'plan' => 'pro',
            'amount' => 100.00,
            'status' => 'active',
            'created_at' => now()
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('totalUsers');
        $response->assertViewHas('salesData');
    }
}
