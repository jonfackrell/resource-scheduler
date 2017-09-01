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
        'password' => Hash::make('secret'),
        'remember_token' => str_random(10),
        'department' => 1
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
        'description' => $faker->paragraph(2)
    ];
});

$factory->define(App\Models\Printer::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(1),
        'description' => $faker->paragraph(2),
        'image' => 'https://www.lulzbot.com/sites/default/files/TAZ_6_Angle_Main_Product_Page.png',
        'department' => $faker->numberBetween(1, 5),
        'flat_fee' => $faker->numberBetween(0, 3),
        'per_hour' => $faker->numberBetween(0, 2),
        'overtime_fee' => $faker->numberBetween(0, 1),
        'overtime_start' => $faker->numberBetween(12, 24)
    ];
});

$factory->define(App\Models\Filament::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(1),
        'description' => $faker->paragraph(2),
        'department' => $faker->numberBetween(1, 5),
        'cost_per_gram' => 2.5,
        'add_cost_per_gram' => 5,
        'multiplier' => $faker->numberBetween(1, 3)
    ];
});

$factory->define(App\Models\Color::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(3)
    ];
});

$factory->define(App\Models\PrintJob::class, function (Faker\Generator $faker) {
    return [
        'patron' => $faker->numberBetween(1, 20),
        'department' => 1,
        'filament' => $faker->numberBetween(1, 3),
        'color' => $faker->numberBetween(1, 10),
        'filename' => $faker->domainName,
        'time' => $faker->numberBetween(60, 3600),
        'weight' => $faker->randomDigit(100, 2000),
        'options' => ['infill' => 20, 'quality', 'support' => true],
        'status' => $faker->numberBetween(1, 4)
    ];
});
