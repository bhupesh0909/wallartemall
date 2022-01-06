<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Chip;
use Faker\Generator as Faker;

$factory->define(Chip::class, function (Faker $faker) {

    return [
        'user_id' => $faker->word,
        'chips_amount' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
