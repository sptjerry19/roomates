<?php

namespace Database\Seeders;

use App\Models\Admin\SourceValue;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourceValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'jerryPham@gmail.com')->first();
        $companyId = $user->company_id;

        $sourceValue1 = SourceValue::create([
            'name' => 'Shoppee',
            'value' => 5.6,
            'company_id' => $companyId,
            'source_id' => 1
        ]);

        $sourceValue2 = SourceValue::create([
            'name' => 'Grab',
            'value' => 10000,
            'company_id' => $companyId,
            'source_id' => 2
        ]);

        $sourceValue3 = SourceValue::create([
            'name' => 'Be',
            'value' => 5,
            'company_id' => $companyId,
            'source_id' => 3
        ]);
    }
}
