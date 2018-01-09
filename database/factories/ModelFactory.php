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

$factory->define(App\Model\User::class, function (Faker $faker) {
    $team = ['PHP', 'SA', 'QC', 'BO', 'Android', 'IOS', 'FE', 'Ruby'];
    return [
        'employee_code' => 'AT-' . rand(10000, 99999),
        'name'                  => $faker->name,
        'email'                  => $faker->name.'@asiantech.vn',
        'team'                   => $team[array_rand($team)],
        'role'                     => rand(0, 1),
    ];
 });

$factory->define(App\Model\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Model\Book::class, function (Faker $faker) {
    return [
        'QRcode' => $faker->ean13,
        'name' => $faker->name,
        'author' => $faker->name,
        'year' => $faker->year,
        'description' => $faker->text,
        'price' => $faker->numberBetween($min = 1000, $max = 9000),
        'avg_rating' => $faker->numberBetween($min = 1, $max = 5),
        'total_rating' => $faker->numberBetween($min = 1, $max = 20),
        'image' => $faker->image,
        'status' => $faker->numberBetween($min = 0, $max = 1),
    ];
});

$factory->define(App\Model\Borrowing::class, function (Faker $faker) {
    return [
        'from_date' => $faker->datetime,
        'to_date' => $faker->datetime,
    ];
});

$factory->define(App\Model\Post::class, function (Faker $faker) {
    return [
        'postable_id' => $faker->numberBetween($min = 1, $max = 10),        
        'postable_type' => $faker->randomElement(['Review', 'Find', 'Status']),
        'content' => $faker->text
    ];
});

$factory->define(App\Model\Rating::class, function (Faker $faker) {
    return [
        'rating' => $faker->numberBetween($min = 0, $max =5),
    ];
});

$factory->define(App\Model\Favorite::class, function (Faker $faker) {
    return [
    ];
});

$factory->define(App\Model\Donator::class, function (Faker $faker) {
    return [
    ];
});

