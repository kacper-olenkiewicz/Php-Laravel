<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Resetowanie cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Definicja Uprawnień 
        $permissions = [
            'manage rentals',           // Tylko SuperAdmin
            'manage users',             // Tylko SuperAdmin
            'manage products',          // Owner & Employee
            'manage categories',        // Owner & Employee
            'manage bookings',          // Owner & Employee
            'view reports',             // Owner
            'process payments',         // Employee
            'view products public',     // Customer
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // 2. Definicja Ról 

        // SUPER ADMIN 
        $superAdminRole = Role::findOrCreate('SuperAdmin');
        $superAdminRole->givePermissionTo(Permission::all());

        // RENTAL OWNER 
        $ownerRole = Role::findOrCreate('RentalOwner');
        $ownerRole->givePermissionTo([
            'manage products',
            'manage categories',
            'manage bookings',
            'view reports',
        ]);

        // EMPLOYEE 
        $employeeRole = Role::findOrCreate('Employee');
        $employeeRole->givePermissionTo([
            'manage products',
            'manage bookings',
            'process payments',
        ]);

        // CUSTOMER 
        $customerRole = Role::findOrCreate('Customer');
        $customerRole->givePermissionTo([
            'view products public',
        ]);

        $this->command->info('Roles and Permissions seeded successfully.');
    }
}