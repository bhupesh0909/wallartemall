<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GameType;
use Faker\Generator as Faker;

$factory->define(GameType::class, function (Faker $faker) {

    return [
        'game_type' => $faker->word,
        'game_icon' => $faker->word,
        'is_active' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
