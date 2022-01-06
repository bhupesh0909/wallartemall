<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Refer;
use Faker\Generator as Faker;

$factory->define(Refer::class, function (Faker $faker) {

    return [
        'reffer_by' => $faker->word,
        'reffer_to' => $faker->word,
        'status' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
