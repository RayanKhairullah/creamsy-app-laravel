<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'access dashboard admin',
            'access dashboard manager',
            'impersonate',
            // Users
            'view users', 'create users', 'update users', 'delete users',
            // Roles
            'view roles', 'create roles', 'update roles', 'delete roles',
            // Permissions
            'view permissions', 'create permissions', 'update permissions', 'delete permissions',
            // Products
            'view products', 'create products', 'update products', 'delete products',
            // Discounts
            'view discounts', 'create discounts', 'update discounts', 'delete discounts',
            // Transactions
            'view transactions', 'create transactions', 'update transactions', 'delete transactions',
            // Receipts
            'view receipts', 'print receipt',
            // POS actions
            'pos access', 'apply discount',
        ];

        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate([
                'name' => $permission,
            ]);
        }

    }
}
