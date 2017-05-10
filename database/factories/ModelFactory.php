<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->name,
        'password' => $password ?: $password = bcrypt('secret'),
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'birthday'  => $faker->dateTime(),
        'country' => $faker->country(),
        'city' => $faker->city(),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\HumanMigration::class, function (Faker\Generator $faker) {
    return [
        'departure_longitude' => $faker->longitude(),
        'departure_latitude' => $faker->latitude(),
        'arrival_longitude' => $faker->longitude(),
        'arrival_latitude' => $faker->latitude(),
        'adults'  => $faker->numberBetween(0,5),
        'children' => $faker->numberBetween(0,10),
        'reason' => $faker->realText(200),
        'user_id' => $faker->numberBetween($min = 1, $max = 100),
    ];
});
