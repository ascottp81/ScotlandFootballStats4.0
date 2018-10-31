<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Match::class, function (Faker $faker) {

    return [
        'date' => '1996-06-18 00:00:00',
        'opponent_id' => '73',
        'ha' => 'H',
        'result' => 'W 1-0'
    ];
});

$factory->define(App\Models\Opponent::class, function (Faker $faker) {

    return [
        'id' => '73',
        'name' => 'West Germany',
        'abbr_name' => 'W. Germany'
    ];
});
