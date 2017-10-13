<?php

class WriteCommentTest extends FeatureTestCase
{
    public function test_a_user_can_write_a_comment()
    {
        $post = $this->createPost();

        $user = $this->defaultUser();

        $this->actingAs($user)
            ->visit($post->url)
            ->type('Un comentario', 'comment')
            ->press('Publicar comentario');

        $this->seeInDatabase('comments', [
            'comment' => 'Un comentario',
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $this->seePageIs($post->url);
    }

    public function test_write_comment_form_validation()
    {
        $post = $this->createPost();

        $this->actingAs($this->defaultUser())
            ->visit($post->url)
            ->press('Publicar comentario')
            ->seePageIs($post->url)
            ->seeErrors([
                'comment' => 'El camp comentari és obligatori'
            ]);
    }
}
