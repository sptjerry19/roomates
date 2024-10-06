<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = Permission::create([
            'name' => 'view website', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $permission1 = Permission::create([
            'name' => 'manage all website', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $permission2 = Permission::create([
            'name' => 'manage an website', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $permission3 = Permission::create([
            'name' => 'config SEO for website', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $permission4 = Permission::create([
            'name' => 'create all news content of the website', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $permission5 = Permission::create([
            'name' => 'edit all news content of the website', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $permission6 = Permission::create([
            'name' => 'delete all news content of the website', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $permission7 = Permission::create([
            'name' => 'manage the recruitment section on the website', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $permission8 = Permission::create([
            'name' => 'manage all products on the website', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $permission9 = Permission::create([
            'name' => 'manage permissions for user on the website', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $permission10 = Permission::create([
            'name' => 'view reports', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);

        $permission11 = Permission::create([
            'name' => 'export reports', // Tên của permission
            'guard_name' => 'api', // Đảm bảo guard_name khớp với guard được sử dụng (web mặc định)
        ]);
    }
}