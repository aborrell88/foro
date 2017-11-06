<?php

class ShowPostTest extends FeatureTestCase
{
    function test_a_user_can_see_the_post_details()
    {
        // Having
        $user = $this->defaultUser([
            'first_name' => 'Alejandro',
            'last_name' => 'Borrell'
        ]);

        $post = $this->createPost([
            'title' => 'Como instalar Laravel',
            'body' => 'Este es el contenido del post',
            'user_id' => $user->id
        ]);

        // When
        $this->visit($post->url)
            ->seeInElement('h1', $post->title)
            ->see($post->body)
            ->see('Alejandro Borrell');
    }

    function test_old_urls_are_redirected()
    {
        // Having
        $post = $this->createPost([
            'title' => 'Old title'
        ]);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->visit($url)
            ->seePageIs($post->url);

    }

}
