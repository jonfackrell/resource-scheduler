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
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'department' => $faker->randomDigit(0, 5)
    ];
});


$factory->define(App\Models\Department::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word(),
        'description' => $faker->paragraph(3)
    ];
});


$factory->define(App\Models\Filament::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(3),
        'description' => $faker->paragraph(3),
        'quantity' => $faker->randomDigit(0, 10)
    ];
});
