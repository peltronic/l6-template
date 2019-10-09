<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Account::class, function (Faker $faker) {
    return [
        'aname' => $faker->company,
        'adesc' => $faker->sentence,
    ];
});
