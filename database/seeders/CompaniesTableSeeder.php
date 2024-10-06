<?php

namespace Database\Seeders;

use App\Models\Admin\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Jerry billiard and Coffee',
            'company_name' => 'First Company Ltd.',
            'representative_name' => 'John Doe',
            'office_name' => 'Head Office',
            'phone' => '123456789',
            'address' => '123 First Street, City, Country',
            'email' => 'contact@firstcompany.com',
            'relevant_emails' => 'support@firstcompany.com',
            'position' => 'CEO',
            'tax_code' => '1234567890',
            'fax' => '123-456-789',
            'bank_account_number' => '1234567890',
            'bank_account_name' => 'First Company Bank Account',
            'bank' => 'First Bank',
            'logo' => 'logo1.png',
            'note' => 'Note for the first company.',
            'commission_percent' => 5.00,
            'balance' => 10000.00,
            'display_price' => true,
            'status' => 1,
        ]);

        Company::create([
            'name' => 'Ami Coffee',
            'company_name' => 'Second Company Ltd.',
            'representative_name' => 'Jane Smith',
            'office_name' => 'Branch Office',
            'phone' => '987654321',
            'address' => '456 Second Avenue, City, Country',
            'email' => 'info@secondcompany.com',
            'relevant_emails' => 'sales@secondcompany.com',
            'position' => 'Manager',
            'tax_code' => '0987654321',
            'fax' => '987-654-321',
            'bank_account_number' => '0987654321',
            'bank_account_name' => 'Second Company Bank Account',
            'bank' => 'Second Bank',
            'logo' => 'logo2.png',
            'note' => 'Note for the second company.',
            'commission_percent' => 10.00,
            'balance' => 20000.00,
            'display_price' => false,
            'status' => 0,
        ]);
    }
}
