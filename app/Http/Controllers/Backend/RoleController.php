<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

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
            'name' => 'required|string|max:255',
        ]);

        Role::create(['name' => $request->name]);

        // sweet alert
        toast('New Role added!', 'success');

        return redirect()->back();
    }

    public function permissionStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
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

    public function getRole(Request $request)
    {
        //INCOMPLETE........

        $cid = $request->post('cid');

        $allPermissions  = Permission::all();

        $permissions = Role::findById($cid)->permissions;

        $html = '';

        foreach ($permissions as $permission) {

            $html .= '<label class="form-check">
                        <input class="form-check-input" type="checkbox" name="permission_id[]"
                            value="' . $permission->id . '" checked />
                        <span class="form-check-label">' . $permission->name . '</span>
                    </label>';
        }
        echo $html;
    }
}
