<?php

namespace Modules\Admin\Services;

use Modules\Admin\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    /**
     * Log an action in the audit log.
     *
     * @param string $action The action performed (e.g., 'created', 'updated')
     * @param string $module The module where the action occurred
     * @param string|null $description Detailed description
     * @param array|null $metadata Additional data (old/new values)
     * @param int|null $userId User performing the action (defaults to auth user)
     */
    public function log(string $action, string $module, ?string $description = null, ?array $metadata = null, ?int $userId = null): void
    {
        AuditLog::create([
            'user_id' => $userId ?? Auth::id(),
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
        ]);
    }
}
