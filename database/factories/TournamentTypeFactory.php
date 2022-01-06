<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TournamentType;
use Faker\Generator as Faker;

$factory->define(TournamentType::class, function (Faker $faker) {

    return [
        'tournament_type' => $faker->word,
        'status' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
