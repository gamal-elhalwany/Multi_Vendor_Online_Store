<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = User::create([
        //     'name' => 'testAdmin',
        //     'username' => 'testAdmin',
        //     'email' => 'tadmin@gmail.com',
        //     'phone_number' => '+20124539870',
        //     'password' => Hash::make('00000000'),
        //     'guard_name' => 'admin',
        // ]);

        // $role = Role::create(['name' => 'editor']);

        // $permissions = Permission::pluck('id','id')->all();

        // $role->syncPermissions($permissions);

        // $user->assignRole([$role->id]);
    }
}
