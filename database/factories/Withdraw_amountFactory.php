<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Withdraw_amount;
use Faker\Generator as Faker;

$factory->define(Withdraw_amount::class, function (Faker $faker) {

    return [
        'user_id' => $faker->word,
        'amount' => $faker->word,
        'is_released' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
