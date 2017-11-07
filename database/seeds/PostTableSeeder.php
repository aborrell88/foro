<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    public function run()
    {
        factory(\App\Post::class, 100)->create();
    }
}
