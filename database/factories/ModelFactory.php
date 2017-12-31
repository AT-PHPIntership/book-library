<?php

use App\Model\Book;
use App\Model\Borrow;
use App\Model\Comment;
use App\Model\Category;
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

$factory->define(App\Model\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Model\Book::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'author' => $faker->name,
        'year' => $faker->year,
        'description' => $faker->text,
        'donate_by' => $faker->name,
        'avg_rating' => $faker->numberBetween($min = 1, $max = 5),
        'total_rating' => $faker->numberBetween($min = 1, $max = 20),
        'image' => $faker->image,
        'status' => $faker->numberBetween($min = 0, $max = 1),

    ];
});

$factory->define(App\Model\Borrow::class, function (Faker $faker) {
    return [
        'from_date' => $faker->datetime,
        'to_date' => $faker->datetime,
    ];
});

$factory->define(App\Model\Comment::class, function (Faker $faker) {
    return [
        'target_id' => $faker->numberBetween($min = 1, $max = 15),
        'target_table' => $faker->randomElement(['Status','Find','Review']),
        'parent_id' => $faker->numberBetween($min = 1, $max = 2),
        'content' => $faker->text
    ];
});

$factory->define(App\Model\LikeAndShare::class, function (Faker $faker) {
    return [
        'like' => $faker->numberBetween($min = 0, $max =1),
        'share' => $faker->numberBetween($min = 0, $max =1),
    ];
});

$factory->define(App\Model\Information::class, function (Faker $faker) {
    return [
        'hobby' => $faker->text,
        'type' => $faker->randomElement(['Status','Find','Review']),
    ];
});
