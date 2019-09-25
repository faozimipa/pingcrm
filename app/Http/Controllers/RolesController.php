<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        return Inertia::render('Roles/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search'),
            'roles' => Role::orderBy('name')
                ->paginate()
                ->only('id', 'name', 'guard_name'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Roles/Create');
    }


    public function store()
    {
        Role::create(
            \Illuminate\Support\Facades\Request::validate([
                'name' => ['required', 'max:100'],
            ])
        );
        return Redirect::route('roles')->with('success', 'Roles created.');
    }

    public function destroy($id)
    {
        $role = Role::findById($id);
        $role->delete();
        return Redirect::route('roles')->with('success', 'Role deleted.');
    }

}
