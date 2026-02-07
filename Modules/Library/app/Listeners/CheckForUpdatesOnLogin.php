<?php

namespace Modules\Library\Listeners;

use Illuminate\Auth\Events\Login;
use Modules\Billing\Models\MaterialPurchase;
use Illuminate\Support\Facades\Session;

class CheckForUpdatesOnLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        // Check if any purchased resource was updated recently (e.g., last 7 days)
        // A better approach would be tracking 'last_seen_updates' per user, but for now:
        // If resource updated_at > user->last_login_at (from previous session)

        $lastLogin = $user->last_login_at ?? now()->subMonth();

        $hasUpdates = MaterialPurchase::where('user_id', $user->id)
            ->whereHas('resource', function($query) use ($lastLogin) {
                $query->where('updated_at', '>', $lastLogin)
                      ->where('version', '!=', '1.0');
            })
            ->exists();

        if ($hasUpdates) {
            session()->flash('version_updates', true);
        }
    }
}
