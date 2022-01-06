<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserRegistration;
use Faker\Generator as Faker;

$factory->define(UserRegistration::class, function (Faker $faker) {

    return [
        'username' => $faker->word,
        'email' => $faker->word,
        'dob' => $faker->word,
        'gender' => $faker->word,
        'state' => $faker->word,
        'social_media' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
