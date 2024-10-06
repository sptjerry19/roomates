<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'jerryPham',
            'email' => 'jerryPham@gmail.com',
            'company_id' => 1,
            'password' => Hash::make('L14112003l@'),
        ]);

        $role = Role::findByName('Admin');

        $user->assignRole($role);

        $user = User::create([
            'name' => 'mayPos',
            'email' => 'mayPos@gmail.com',
            'company_id' => 1,
            'shop_id' => 2,
            'password' => Hash::make('123456@A'),
        ]);

        $role = Role::findByName('Viewer');

        $user->assignRole($role);
    }
}
