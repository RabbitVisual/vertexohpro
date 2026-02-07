<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Library\Models\LibraryResource;
use Modules\Admin\Services\AuditService;

class MaterialModerationController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index()
    {
        $pendingMaterials = LibraryResource::pending()->with('user')->paginate(10);
        return view('admin::moderation.index', compact('pendingMaterials'));
    }

    public function approve($id)
    {
        $material = LibraryResource::findOrFail($id);
        $material->update(['status' => 'approved']);

        $this->auditService->log(
            action: 'approved',
            module: 'Library',
            description: "Approved material: {$material->title}",
            metadata: ['resource_id' => $material->id]
        );

        return redirect()->route('admin.moderation.index')->with('success', 'Material aprovado com sucesso.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        $material = LibraryResource::findOrFail($id);
        $material->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('reason')
        ]);

        $this->auditService->log(
            action: 'rejected',
            module: 'Library',
            description: "Rejected material: {$material->title}. Reason: {$request->input('reason')}",
            metadata: ['resource_id' => $material->id]
        );

        return redirect()->route('admin.moderation.index')->with('success', 'Material reprovado.');
    }
}
