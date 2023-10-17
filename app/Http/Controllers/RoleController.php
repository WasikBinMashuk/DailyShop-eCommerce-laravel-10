<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('backend.roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Role::create(['name' => $request->name]);

        // sweet alert
        toast('New Role added!', 'success');

        return redirect()->back();
    }

    public function permissionStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Permission::create(['name' => $request->name]);

        // sweet alert
        toast('New Permission added!', 'success');

        return redirect()->back();
    }

    public function rolePermissionStore(Request $request)
    {
        $permissions = $request->input('permission_id');

        $role = Role::findById($request->role_id);
        $role->givePermissionTo($permissions);

        // sweet alert
        toast('Role/Permissions added!', 'success');

        return redirect()->back();
    }
}
