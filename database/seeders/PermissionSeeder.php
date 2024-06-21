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
            'No Permissions',

            'list-role',
            'create-role',
            'show-role',
            'edit-role',
            'delete-role',

            'list-product',
            'create-product',
            'show-product',
            'edit-product',
            'delete-product',

            'list-category',
            'create-category',
            'show-category',
            'edit-category',
            'delete-category',

            'list-order',
            'create-order',
            'show-order',
            'edit-order',
            'delete-order',

            'list-admin',
            'create-admin',
            'show-admin',
            'edit-admin',
            'delete-admin',

            'list-editor',
            'create-editor',
            'show-editor',
            'edit-editor',
            'delete-editor',

            'list-user',
            'create-user',
            'show-user',
            'edit-user',
            'delete-user',

            'list-coupon',
            'create-coupon',
            'edit-coupon',
            'delete-coupon',
        ];

        foreach ($permissions as $permission) {
            $thePermission = Permission::firstOrCreate(['name' => $permission]);
        }
    }
}