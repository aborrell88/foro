<?php

use App\Post;

class ShowPostTest extends FeatureTestCase
{
    function test_a_user_can_see_the_post_details()
    {
        // Having

        $user = $this->defaultUser([
            'name' => 'Alejandro Borrell'
        ]);

        $post = factory(Post::class)->make([
            'title' => 'Como instalar Laravel',
            'body' => 'Este es el contenido del post'
        ]);

        $user->posts()->save($post);

        // When
        $this->visit(route('posts.show', $post))
            ->seeInElement('h1', $post->title)
            ->see($post->body)
            ->see($user->name);
    }
}
