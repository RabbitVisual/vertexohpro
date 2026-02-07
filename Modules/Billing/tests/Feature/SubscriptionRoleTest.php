<?php

namespace Modules\Billing\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Modules\Billing\Models\Subscription;
use Modules\Admin\Services\AuditService;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionRoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create roles manually since RefreshDatabase wipes them
        Role::create(['name' => 'Professor Free']);
        Role::create(['name' => 'Professor Pro']);
    }

    public function test_user_gets_pro_role_on_active_subscription()
    {
        $user = User::factory()->create();
        $user->assignRole('Professor Free');

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => 'pro_plan',
            'status' => 'active', // Should trigger observer
            'current_period_end' => now()->addMonth(),
        ]);

        $this->assertTrue($user->fresh()->hasRole('Professor Pro'));
        $this->assertFalse($user->fresh()->hasRole('Professor Free'));
    }

    public function test_user_downgraded_on_subscription_cancel()
    {
        $user = User::factory()->create();
        $user->assignRole('Professor Pro');

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => 'pro_plan',
            'status' => 'active',
            'current_period_end' => now()->addMonth(),
        ]);

        $subscription->update(['status' => 'canceled']);

        $this->assertTrue($user->fresh()->hasRole('Professor Free'));
        $this->assertFalse($user->fresh()->hasRole('Professor Pro'));
    }
}
