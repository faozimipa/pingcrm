<?php

namespace Tests\Feature;

use App\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Account;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionsTest extends TestCase
{

    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();

        $permission = Permission::create(['name' => 'role-list']);
        $role = Role::create(['name' => 'TestRole']);

        $account = Account::create(['name' => 'Acme Corporation 2']);
        $this->user = factory(User::class)->create([
            'account_id' => $account->id,
            'first_name' => 'John Test',
            'last_name' => 'Do Test',
            'email' => 'johndoetest@example.com',
            'owner' => true,
        ]);

        $this->user->assignRole('TestRole');

//        $role->givePermissionTo('role-list');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_view_organizations()
    {

        $this->actingAs($this->user)
            ->get('/permissions')
            ->assertStatus(200);
    }
}
