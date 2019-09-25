<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataRole['name'] = 'admin';
        $dataRole['guard_name'] = 'web';
        $role = Role::create($dataRole);

        $permissions = [
            'guest',
            'login-enable',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'profile-show',
            'profile-edit',
            'profile-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'permission-assign'
        ];

        // add special superadmin
//        Permission::create(['name' => 'superadmin']);
        $user = User::where('email', 'faozimipa@gmail.com')->first();

        $user->assignRole('admin');
//        $user->givePermissionTo('superadmin');

//        Adding permissions to a user
//        $user->givePermissionTo('edit articles');
//
//        // Adding permissions via a role
//        $user->assignRole('writer');
//
//        $role->givePermissionTo('edit articles');

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
            $role->givePermissionTo($permission);
        }

        // create user role
        $dataRoleUser['name'] = 'user';
        $dataRoleUser['guard_name'] = 'web';
        $roleUser = Role::create($dataRoleUser);
        $roleUser->givePermissionTo([
            'guest',
            'profile-show',
            'profile-edit',
            'profile-delete',
        ]);

        $users = User::where('email', '!=', 'faozimipa@gmail.com')->get();
        foreach ($users as $u) {
            $u->assignRole('user');
        }
        // create guest role
        $dataRoleGuest['name'] = 'guest';
        $dataRoleGuest['guard_name'] = 'web';
        $roleGuest = Role::create($dataRoleGuest);
        $roleGuest->givePermissionTo([
            'guest',
        ]);

    }
}
