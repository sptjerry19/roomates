<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create([
            'name' => 'Viewer', // Tên của role
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $role1 = Role::create([
            'name' => 'Supper Admin', // Tên của role
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $role2 = Role::create([
            'name' => 'Admin', // Tên của role
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $role3 = Role::create([
            'name' => 'SEO config', // Tên của role
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $role4 = Role::create([
            'name' => 'Content creator', // Tên của role
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $role5 = Role::create([
            'name' => 'A Human Resources (HR)', // Tên của role
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $role6 = Role::create([
            'name' => 'product manager', // Tên của role
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $role7 = Role::create([
            'name' => 'User management', // Tên của role
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $role8 = Role::create([
            'name' => 'Reporter', // Tên của role
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);
    }
}
