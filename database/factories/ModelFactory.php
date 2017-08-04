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
        'department' => $faker->randomDigit(1, 5)
    ];
});

$factory->define(App\Models\Patron::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10)
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
        'name' => $faker->sentence(1),
        'description' => $faker->paragraph(2)
    ];
});

$factory->define(App\Models\Color::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(3)
    ];
});

$factory->define(App\Models\PrintJob::class, function (Faker\Generator $faker) {
    return [
        'patron' => $faker->randomDigit(1, 10),
        'department' => $faker->randomDigit(0, 5),
        'filament' => $faker->randomDigit(0, 20),
        'color' => $faker->randomDigit(0, 10),
        'filename' => $faker->domainName,
        'time' => $faker->randomDigit(2, 12),
        'weight' => $faker->randomDigit(100, 2000),
        'options' => ['infill' => 20, 'quality', 'support' => true],
        'status' => $faker->randomDigit(1, 4)
    ];
});
