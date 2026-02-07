<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;

class HealthController extends Controller
{
    protected $requiredRoles = ['admin', 'teacher', 'student'];
    protected $requiredPermissions = [
        'manage users', 'view dashboard', 'manage classes', 'manage grades'
    ];

    public function index()
    {
        $status = [];

        // Check Roles
        foreach ($this->requiredRoles as $role) {
            $exists = Role::where('name', $role)->exists();
            $status[] = [
                'type' => 'Role',
                'name' => $role,
                'status' => $exists ? 'OK' : 'MISSING'
            ];
        }

        // Check Permissions
        foreach ($this->requiredPermissions as $perm) {
            $exists = Permission::where('name', $perm)->exists();
            $status[] = [
                'type' => 'Permission',
                'name' => $perm,
                'status' => $exists ? 'OK' : 'MISSING'
            ];
        }

        $allGood = !collect($status)->contains('status', 'MISSING');

        return view('admin::health.index', compact('status', 'allGood'));
    }

    public function fix()
    {
        // Fix Roles
        foreach ($this->requiredRoles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Fix Permissions
        foreach ($this->requiredPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Assign basic permissions (Example)
        $admin = Role::findByName('admin');
        $admin->syncPermissions(Permission::all());

        return redirect()->route('admin.health')->with('success', 'Permissões e Roles sincronizadas com sucesso.');
    }
}
