<?php

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountsTableSeeder extends Seeder
{
    public function run()
    {
        $accounts = factory(Account::class)->times(50)->make()->each(function ($account, $index) {
            if ($index == 0) {
                // $account->field = 'value';
            }
        });

        Account::insert($accounts->toArray());
    }

}

