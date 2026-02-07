<?php

namespace Modules\Billing\Observers;

use Modules\Billing\Models\Subscription;
use Modules\Admin\Services\AuditService;

class SubscriptionObserver
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function created(Subscription $subscription): void
    {
        $this->handleStatusChange($subscription);
    }

    public function updated(Subscription $subscription): void
    {
        if ($subscription->isDirty('status')) {
            $this->handleStatusChange($subscription);
        }
    }

    protected function handleStatusChange(Subscription $subscription): void
    {
        $user = $subscription->user;

        if ($subscription->status === 'active') {
            if ($user->hasRole('Professor Free')) {
                $user->removeRole('Professor Free');
            }
            $user->assignRole('Professor Pro');

            $this->auditService->log('role_change', 'Billing', 'User role upgraded to Professor Pro', ['user_id' => $user->id]);
        } else {
            if ($user->hasRole('Professor Pro')) {
                $user->removeRole('Professor Pro');
            }
            $user->assignRole('Professor Free');

            $this->auditService->log('role_change', 'Billing', 'User role downgraded to Professor Free', ['user_id' => $user->id]);
        }
    }
}
