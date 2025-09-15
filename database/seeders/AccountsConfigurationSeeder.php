<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountsConfiguration;

class AccountsConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultConfigs = [
            ['account_name' => 'Cash', 'account_type' => 'Control Group', 'account_code' => '1201000000', 'sort_order' => 1],
            ['account_name' => 'Retained Surplus', 'account_type' => 'Subsidiary Ledger', 'account_code' => '2101001001', 'sort_order' => 2],
            ['account_name' => 'Cash in Hand', 'account_type' => 'General Ledger', 'account_code' => '1201001000', 'sort_order' => 3],
            ['account_name' => 'Cash at Bank', 'account_type' => 'General Ledger', 'account_code' => '1201002000', 'sort_order' => 4],
            ['account_name' => 'Advance', 'account_type' => 'Control Group', 'account_code' => '1301000000', 'sort_order' => 5],
            ['account_name' => 'Receivable', 'account_type' => 'Control Group', 'account_code' => '1401000000', 'sort_order' => 6],
            ['account_name' => 'Payable', 'account_type' => 'Control Group', 'account_code' => '2001000000', 'sort_order' => 7],
            ['account_name' => 'Sales', 'account_type' => 'Control Group', 'account_code' => '3001000000', 'sort_order' => 8],
            ['account_name' => 'Goods Sales', 'account_type' => 'General Ledger', 'account_code' => '3001001000', 'sort_order' => 9],
            ['account_name' => 'Wages Sales', 'account_type' => 'General Ledger', 'account_code' => '3001002000', 'sort_order' => 10],
            ['account_name' => 'Sales Return', 'account_type' => 'Control Group', 'account_code' => '3101000000', 'sort_order' => 11],
            ['account_name' => 'Sales Return- Goods', 'account_type' => 'General Ledger', 'account_code' => '3101001000', 'sort_order' => 12],
            ['account_name' => 'Sales Return-Wages', 'account_type' => 'General Ledger', 'account_code' => '3101002000', 'sort_order' => 13],
            ['account_name' => 'Cost of Goods Sold', 'account_type' => 'Control Group', 'account_code' => '4001000000', 'sort_order' => 14],
            ['account_name' => 'Inventory Stock', 'account_type' => 'Control Group', 'account_code' => '1501000000', 'sort_order' => 15],
            ['account_name' => 'Raw Materials', 'account_type' => 'Subsidiary Ledger', 'account_code' => '1501001001', 'sort_order' => 16],
            ['account_name' => 'Work-in-Progress', 'account_type' => 'Subsidiary Ledger', 'account_code' => '1501001002', 'sort_order' => 17],
            ['account_name' => 'Finished Goods', 'account_type' => 'Subsidiary Ledger', 'account_code' => '1501001003', 'sort_order' => 18],
            ['account_name' => 'Materials Purchase', 'account_type' => 'General Ledger', 'account_code' => '4001001000', 'sort_order' => 19],
            ['account_name' => 'Purchase Return', 'account_type' => 'Control Group', 'account_code' => '4101000000', 'sort_order' => 20],
            ['account_name' => 'Fixed Assets', 'account_type' => 'Control Group', 'account_code' => '1101000000', 'sort_order' => 21]
        ];

        foreach ($defaultConfigs as $config) {
            AccountsConfiguration::create($config);
        }
    }
}