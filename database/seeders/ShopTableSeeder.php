<?php

namespace Database\Seeders;

use App\Models\Admin\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'jerryPham@gmail.com')->first();

        Shop::create([
            'user_id' => $user->id,
            'company_id' => 1,
            'name' => 'Jerry Coffee',
            'adress' => 'Jerry Coffee CS1 Nguyễn Hoàng, Ami Coffee CS1 Lê Văn Hiến'
        ]);

        Shop::create([
            'user_id' => $user->id,
            'company_id' => 1,
            'name' => 'Cheese Coffee',
            'adress' => 'Jerry Coffee CS2 Nguyễn Hoàng, Ami Coffee CS2 Lê Văn Hiến'
        ]);

        Shop::create([
            'user_id' => $user->id,
            'company_id' => 1,
            'name' => 'Billiard Coffee',
            'adress' => 'Jerry Coffee CS3 Nguyễn Hoàng, Ami Coffee CS3 Lê Văn Hiến'
        ]);

        Shop::create([
            'user_id' => $user->id,
            'company_id' => 1,
            'name' => 'Gaming and Coffee',
            'adress' => 'Jerry Coffee CS4 Nguyễn Hoàng, Ami Coffee CS4 Lê Văn Hiến'
        ]);
    }
}
