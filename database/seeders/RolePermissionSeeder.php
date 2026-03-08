<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create permissions
        $permissions = [
            'view_admin_dashboard',
            'manage_clients',
            'manage_services',
            'manage_projects',
            'manage_billings',
            'manage_users',
            'manage_employees',
            'manage_roles',
            'view_reports',
            'delete_data',
            'export_data',
            'view_client_dashboard',
            'send_messages',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        
        // Super Admin - Full Access
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // Admin (Sub Admin) - Almost full access but restricted on one critical feature
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminPermissions = Permission::whereNotIn('name', ['manage_roles'])
            ->get();
        $admin->syncPermissions($adminPermissions);

        // Data Entry - Can add data but cannot delete/modify
        $dataEntry = Role::firstOrCreate(['name' => 'data_entry', 'guard_name' => 'web']);
        $dataEntryPermissions = Permission::whereIn('name', [
            'view_admin_dashboard',
            'manage_clients',
            'manage_services',
            'manage_projects',
            'view_reports',
            'export_data',
        ])->get();
        $dataEntry->syncPermissions($dataEntryPermissions);

        // Client Service - Can view their service dashboard and send messages
        $clientService = Role::firstOrCreate(['name' => 'client_service', 'guard_name' => 'web']);
        $clientService->syncPermissions([
            Permission::where('name', 'view_client_dashboard')->first(),
            Permission::where('name', 'send_messages')->first(),
        ]);

        // Client Project - Can view their project dashboard and send messages
        $clientProject = Role::firstOrCreate(['name' => 'client_project', 'guard_name' => 'web']);
        $clientProject->syncPermissions([
            Permission::where('name', 'view_client_dashboard')->first(),
            Permission::where('name', 'send_messages')->first(),
        ]);

        // Employee - Can view dashboard and limited features
        $employee = Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'web']);
        $employee->syncPermissions([
            Permission::where('name', 'view_admin_dashboard')->first(),
        ]);
    }
}
