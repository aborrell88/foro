<?php

use App\Post;

class CreatePostsTest extends FeatureTestCase
{
    public function test_a_user_create_a_post()
    {
        $title = 'Esta es una pregunta';
        $body = 'Este es el contenido';

        // Having
        $this->actingAs($user = $this->defaultUser());

        // When
        $this->visit(route('posts.create'))
            ->type($title, 'title')
            ->type($body, 'body')
            ->press('Publicar');

        // Then
        $this->seeInDatabase('posts', [
            'title' => $title,
            'body' => $body,
            'pending' => true,
            'user_id' => $user->id,
            'slug' => 'esta-es-una-pregunta'
        ]);

        $post = Post::first();

        // Test the author is suscribed automatically to the post.
        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        // Test a user is redirected to the posts details after creating it.
        $this->seePageIs($post->url);
    }

    public function test_creating_a_post_requires_authentication()
    {
        $this->visit(route('posts.create'))
             ->seePageIs(route('login'));
    }

    public function test_create_post_form_validation()
    {
        $this->actingAs($this->defaultUser())
            ->visit(route('posts.create'))
            ->press('Publicar')
            ->seePageIs(route('posts.create'))
            ->seeErrors([
                'title' => 'El camp títol és obligatori',
                'body' => 'El camp contingut és obligatori'
            ]);
    }
}