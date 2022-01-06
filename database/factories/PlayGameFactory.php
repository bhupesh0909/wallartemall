<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PlayGame;
use Faker\Generator as Faker;

$factory->define(PlayGame::class, function (Faker $faker) {

    return [
        'game_type' => $faker->word,
        'game_id' => $faker->word,
        'user_id' => $faker->word,
        'total_players' => $faker->word,
        'entry_fee' => $faker->word,
        'game_status' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
