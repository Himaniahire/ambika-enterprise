<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $sections = [
            'company_register',
            'category_of_service',
            'purchase_order',
            'summary',
            'performa',
            'invoice',
            'acc_reports',
            'employee_holidays',
            'employee_categories',
            'employee_posts',
            'employee_advance_salary',
            'employee_details',
            'employee_company_transfer',
            'employee_attendance',
            'employee_salary',
            'emp_reports',
        ];

        foreach ($sections as $section) {
            Permission::firstOrCreate(['name' => $section]);
        }

        // Define Roles and Assign Permissions
        $roles = [
            'superadmin' => $sections,
            'accountant' => [],
            'employee' => [],
        ];

        foreach ($roles as $role => $permissions) {
            $roleObj = Role::firstOrCreate(['name' => $role]);
            $roleObj->syncPermissions($permissions);
        }

    }
}
