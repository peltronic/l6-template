<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Listing::class, function (Faker $faker) {
    return [
        'ltitle' => $faker->catchPhrase,
        'ldesc' => $faker->sentence,
    ];
});
