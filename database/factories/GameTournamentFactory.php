<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GameTournament;
use Faker\Generator as Faker;

$factory->define(GameTournament::class, function (Faker $faker) {

    return [
        't_type' => $faker->word,
        't_id' => $faker->word,
        't_formate' => $faker->word,
        'start_date' => $faker->word,
        'entry' => $faker->word,
        'starting_stack' => $faker->word,
        'prize' => $faker->word,
        'level' => $faker->word,
        'no_of_prizes' => $faker->word,
        'r_user' => $faker->word,
        'cash_prize' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
