<?php

use Illuminate\Database\Seeder;
use App\Models\Listing;

class ListingsTableSeeder extends Seeder
{
    public function run()
    {
        $listings = factory(Listing::class)->times(50)->make()->each(function ($listing, $index) {
            if ($index == 0) {
                // $listing->field = 'value';
            }
        });

        Listing::insert($listings->toArray());
    }

}

