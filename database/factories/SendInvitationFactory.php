<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SendInvitation;
use Faker\Generator as Faker;

$factory->define(SendInvitation::class, function (Faker $faker) {

    return [
        'send_to' => $faker->word,
        'send_by' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
