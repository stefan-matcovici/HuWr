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

use DateTime as DT;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'), 
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'birthday'  => $faker->dateTime(),
        'gender' => $faker->randomDigit>6?'male':'female',
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];
});

$factory->define(App\HumanMigration::class, function (Faker\Generator $faker) {
    return [
        'adults'  => $faker->numberBetween(0,5),
        'children' => $faker->numberBetween(0,10),
        'reason' => $faker->randomElement($array = array ('Economics','War','Personal','Education','Religion','Other')) ,
        'user_id' => $faker->numberBetween($min = 1, $max = 100),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime()
    ];
});
