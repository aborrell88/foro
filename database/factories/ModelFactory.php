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

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'pending' => true, //$faker->boolean(),
        // Se ejecuta solo en caso de no "forzar" el asignamiento de un user_id
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'category_id' => function () {
            return factory(\App\Category::class)->create()->id;
        }
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'comment' => $faker->paragraph(),
        // Se ejecuta solo en caso de no "forzar" el asignamiento de un post_id
        'post_id' => function () {
            return factory(\App\Post::class)->create()->id;
        },
        // Se ejecuta solo en caso de no "forzar" el asignamiento de un user_id
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        }
    ];
});

$factory->define(\App\Category::class, function (Faker\Generator $faker) {
    $name = $faker->unique()->sentence;

    return [
        'name' => $name,
        'slug' => str_slug($name),
    ];
});
