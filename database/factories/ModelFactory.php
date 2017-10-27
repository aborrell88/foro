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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
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
