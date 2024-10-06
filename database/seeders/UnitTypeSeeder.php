<?php

namespace Database\Seeders;

use App\Models\Admin\UnitType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'jerryPham@gmail.com')->first();
        $companyId = $user->company_id;

        $unitType1 = UnitType::create([
            'name' => 'Suất',
            'value' => 1,
            'company_id' => $companyId
        ]);

        $unitType2 = UnitType::create([
            'name' => 'Món',
            'value' => 1,
            'company_id' => $companyId
        ]);

        $unitType3 = UnitType::create([
            'name' => 'Kg',
            'value' => 1,
            'company_id' => $companyId
        ]);
    }
}
