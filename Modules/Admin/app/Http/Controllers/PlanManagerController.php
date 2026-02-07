<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Billing\Models\Plan;
use Modules\Admin\Services\AuditService;

class PlanManagerController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index()
    {
        $plans = Plan::all();
        return view('admin::plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin::plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:plans,slug',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'modules_access' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $plan = Plan::create($validated);

        $this->auditService->log('created', 'Billing', "Created plan: {$plan->name}", $validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plano criado com sucesso.');
    }

    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin::plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:plans,slug,' . $id,
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'modules_access' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $plan->update($validated);

        $this->auditService->log('updated', 'Billing', "Updated plan: {$plan->name}", $validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plano atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        $this->auditService->log('deleted', 'Billing', "Deleted plan: {$plan->name}");

        return redirect()->route('admin.plans.index')->with('success', 'Plano removido com sucesso.');
    }
}
