<?php

namespace App\Http\Controllers;

use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use function PHPSTORM_META\map;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{

    public function index()
    {
        return Inertia::render('Permissions/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search'),
            'permissions' => Permission::orderBy('name')
//                ->filter(Request::only('search'))
                ->paginate()
                ->only('id', 'name', 'guard_name'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Permissions/Create');
    }


    public function store()
    {
        Permission::create(
            \Illuminate\Support\Facades\Request::validate([
                'name' => ['required', 'max:100'],
            ])
        );

        return Redirect::route('permissions')->with('success', 'Permissions created.');
    }


    public function edit(Permission $permission)
    {
        return Inertia::render('Permissions/Edit', [
            'permission' => [
                'id' => $permission->id,
                'name' => $permission->name,
            ],
        ]);
    }

    public function update($id)
    {
        $permission = Permission::findById($id);

        $permission->update(
            \Illuminate\Support\Facades\Request::validate([
                'name' => ['required', 'max:100'],
            ])
        );

        return Redirect::route('permissions.edit', $permission)->with('success', 'Permission updated.');
    }

    public function assign()
    {
        $roles = Role::all();

        $permissions = Permission::all();

        $assigned_permissions = \DB::table('role_has_permissions')->get();

        $data = array();
        foreach ($permissions as $permission) {
            foreach ($roles as $role) {
                $data[$role->id][$permission->id] = $assigned_permissions->where('role_id', $role->id)->where('permission_id', $permission->id)->count() ? true : false;
            }
        }

        return Inertia::render('Permissions/Assign', [
            'permissions' => $permissions,
            'roles' => $roles,
            'assign' => $data,
        ]);
    }

    public function assignUpdate(Request $request)
    {
        $role = Role::findById($request->get('role_id'));
        $permission = Permission::findById($request->get('permission_id'));

        if ($request->get('use_it')) {
            $role->givePermissionTo($permission->name);
        } else {
            $role->revokePermissionTo($permission->name);
        }

        return Redirect::route('permissions.assign')->with('success', 'Assign Permission updated.');

    }

    public function destroy( $id)
    {
        $permission = Permission::findById($id);
        $permission->delete();

        return Redirect::route('permissions')->with('success', 'Permission deleted.');
    }

    public function restore(Permission $permission)
    {
        $permission->restore();

        return Redirect::route('permissions.edit', $permission)->with('success', 'Permission restored.');
    }

}
