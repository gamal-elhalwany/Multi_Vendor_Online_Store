<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'product-list',
            'product-create',
            'product-show',
            'product-edit',
            'product-delete',
            'category-list',
            'category-create',
            'category-show',
            'category-edit',
            'category-delete',
            'order-list',
            'order-create',
            'order-show',
            'order-edit',
            'order-delete',
            'admin-list',
            'admin-create',
            'admin-show',
            'admin-edit',
            'admin-delete',
            'user-list',
            'user-create',
            'user-show',
            'user-edit',
            'user-delete',
         ];

         foreach ($permissions as $permission) {
             $thePermission = Permission::firstOrCreate(['name' => $permission]);
             $thePermission->guard(['web', 'api', 'admin']);
         }

        // Assign permissions to roles
        $role = Role::firstOrCreate(['name' => 'Owner']);
        $role2 = Role::firstOrCreate(['name' => 'Super-admin']);
        $role3 = Role::firstOrCreate(['name' => 'Admin']);
        $role4 = Role::firstOrCreate(['name' => 'Editor']);
        $role5 = Role::firstOrCreate(['name' => 'User']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);
        $role2->syncPermissions($permissions);
        $role3->syncPermissions(['product-list', 'role-list', 'product-create', 'product-show', 'product-edit', 'category-list', 'category-show', 'category-edit', 'order-list', 'order-create', 'order-show', 'order-edit', 'admin-list', 'admin-show', 'user-list', 'user-create','user-show','user-delete']);

        $role4->syncPermissions(['product-list', 'product-create', 'product-show', 'product-edit', 'category-list', 'category-show', 'category-edit', 'user-list', 'user-show']);

        $role5->syncPermissions(['product-list', 'category-list', 'category-show', 'user-list', 'user-show', 'order-list', 'order-create', 'order-show', 'order-edit', 'order-delete']);
    }
}
