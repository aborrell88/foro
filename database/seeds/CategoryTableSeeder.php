<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        \App\Category::forceCreate([
            'name' => 'Laravel',
            'slug' => 'laravel'
        ]);

        \App\Category::forceCreate([
            'name' => 'PHP',
            'slug' => 'php'
        ]);

        \App\Category::forceCreate([
            'name' => 'Javascript',
            'slug' => 'javascript'
        ]);

        \App\Category::forceCreate([
            'name' => 'Vue.js',
            'slug' => 'vue-js'
        ]);

        \App\Category::forceCreate([
            'name' => 'CSS',
            'slug' => 'css'
        ]);

        \App\Category::forceCreate([
            'name' => 'Sass',
            'slug' => 'sass'
        ]);

        \App\Category::forceCreate([
            'name' => 'Git',
            'slug' => 'git'
        ]);

        \App\Category::forceCreate([
            'name' => 'Otras tecnologías',
            'slug' => 'otras-tecnologias'
        ]);

    }
}
