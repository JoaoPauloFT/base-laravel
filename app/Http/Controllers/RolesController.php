<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Role $role) {

        $roles = $role->where('deleted', 0)->get();

        return view('role.index', compact('roles'));
    }

    public static function create() {
        $role = new Role();

        $allRoles = Role::where('deleted', 0)->get();

        foreach ($allRoles as $r) {
            $roles[$r->id] = $r->name;
        }

        return view('role.form', compact('role', 'roles'));
    }

    public static function edit(int $id) {
        $role = Role::find($id);

        return view('role.form', compact('role'));
    }

    public function store(StoreRoleRequest $request, Role $role) {

        $data = $request->all();
        $role->fill($data);
        $role->save();
        $id = $role->id;

        $r = $role->find($data['role_id']);

        if (!$r) {
            return back();
        }

        $permissions = $r->permission->pluck('id');

        foreach ($permissions as $permission) {
            PermissionRole::create(array(
                'permission_id' => $permission,
                'role_id' => $id
            ));
        }

        return redirect()->route('role');
    }

    public function destroy(int $id) {

        $role = Role::find($id);

        if (!$role) {
            return back();
        }

        $role->deleted = 1;
        $role->save();

        return redirect()->route('role');
    }

    public function update(StoreRoleRequest $request, string $id) {

        $role = Role::find($id);

        if (!$role) {
            return back();
        }

        $role->update(
            $request->only([
                'name',
                'description'
            ])
        );

        return redirect()->route('role');
    }

    public function config(Role $r, int $id) {

        $role = $r->find($id);

        if (!$role) {
            return back();
        }

        $permissions = Permission::all();

        $my_permissions = $role->permission->pluck('code');

        $first_view = $permissions[0]->view;

        return view('role.config', compact('role', 'permissions', 'my_permissions', 'first_view'));
    }

    public function save_permission(Request $request, int $id) {
        PermissionRole::where('role_id', $id)->delete();
        $data = $request->all();

        foreach ($data['permission'] as $permission) {
            PermissionRole::create(array(
                'permission_id' => $permission,
                'role_id' => $id
            ));
        }

        $role = Role::find($id);
        $role->touch();

        return redirect()->route('role');
    }
}
