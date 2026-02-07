<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Library\Models\LibraryResource;
use Modules\Admin\Services\AuditService;

class BulkModerationController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index()
    {
        $pendingMaterials = LibraryResource::pending()->with('user')->paginate(50);
        return view('admin::moderation.bulk', compact('pendingMaterials'));
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:library_resources,id',
            'action' => 'required|in:approve,reject',
            'reason' => 'required_if:action,reject|nullable|string',
        ]);

        $ids = $validated['ids'];
        $action = $validated['action'];
        $reason = $request->input('reason');

        if ($action === 'approve') {
            LibraryResource::whereIn('id', $ids)->update(['status' => 'approved']);
            $this->auditService->log('bulk_approved', 'Library', "Bulk approved " . count($ids) . " items.", ['ids' => $ids]);
        } else {
            LibraryResource::whereIn('id', $ids)->update([
                'status' => 'rejected',
                'rejection_reason' => $reason ?? 'Bulk Rejection'
            ]);
            $this->auditService->log('bulk_rejected', 'Library', "Bulk rejected " . count($ids) . " items.", ['ids' => $ids]);
        }

        return redirect()->route('admin.moderation.bulk')->with('success', 'Ação em massa realizada com sucesso.');
    }
}
