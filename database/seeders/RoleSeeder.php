<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin: all permissions
        $superAdmin = Role::query()->updateOrCreate(['name' => 'Super Admin']);
        $manager = Role::query()->updateOrCreate(['name' => 'Manager']);
        $cashier = Role::query()->updateOrCreate(['name' => 'Cashier']);

        $permissions = Permission::all()->pluck('name')->toArray();
        $superAdmin->givePermissionTo($permissions);

        // Manager: manage products, discounts, view transactions, manage users (not roles/permissions, not dashboard)
        $managerPermissions = [
            'access dashboard manager',
            'view products', 'create products', 'update products', 'delete products',
            'view discounts', 'create discounts', 'update discounts', 'delete discounts',
            'view transactions'
        ];
        $manager->syncPermissions($managerPermissions);

        $cashierPermissions = [
            'view products', 'view discounts', 'create transactions', 'view transactions', 'print receipt',
        ];
        $cashier->syncPermissions($cashierPermissions);

    }
}
