<?php

use App\Post;

class PostsListTest extends FeatureTestCase
{
    public function test_a_user_can_see_the_posts_list_and_go_to_the_details()
    {
        $post = $this->createPost([
            'title' => '¿Debo usar Laravel 5.3 o 5.1 LTS?'
        ]);

        $this->visit('/')
            ->seeInElement('h1', 'Posts')
            ->see($post->title)
            ->click($post->title)
            ->seePageIs($post->url) ;
    }

    function test_the_posts_are_paginated()
    {
        // Having...
        $first = factory(Post::class)->create([
            'title' => 'El post más antiguo',
            'created_at' => \Carbon\Carbon::now()->subDays(2)
        ]);

        factory(Post::class)->times(15)->create([
            'created_at' => \Carbon\Carbon::now()->subDay()
        ]);

        $last = factory(Post::class)->create([
           'title' => 'El post más reciente',
            'created_at' => \Carbon\Carbon::now()
        ]);

        $this->visit('/')
            ->see($last->title)
            ->dontSee($first->title)
            ->click('2')
            ->see($first->title)
            ->dontSee($last->title);
    }
}
