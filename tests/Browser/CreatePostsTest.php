<?php

namespace Tests\Browser;

use App\Category;
use App\Post;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreatePostsTest extends DuskTestCase
{
    use DatabaseTransactions;

    protected $title = 'Esta es una pregunta';
    protected $body = 'Este es el contenido';

    public function test_a_user_create_a_post()
    {
        $user = $this->defaultUser();

        $category = factory(Category::class)->create();

        $this->browse(function ($browser) use ($user, $category) {
            $browser->loginAs($user)
                ->visitRoute('posts.create')
                ->type('title', $this->title)
                ->type('body', $this->body)
                ->select('category_id', $category->id)
                ->press('Publicar')
                ->assertPathIs('/posts/1-esta-es-una-pregunta');
        });

        // Then
        $this->assertDatabaseHas('posts', [
            'title' => $this->title,
            'body' => $this->body,
            'pending' => true,
            'user_id' => $user->id,
            'slug' => 'esta-es-una-pregunta'
        ]);

        $post = Post::first();

        // Test the author is suscribed automatically to the post.
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

    }

    public function test_creating_a_post_requires_authentication()
    {
        $this->browse(function ($browser) {
            $browser->visitRoute('posts.create')
                ->assertRouteIs('token');
        });
    }

    public function test_create_post_form_validation()
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->defaultUser())
                ->visitRoute('posts.create')
                ->press('Publicar')
                ->assertRouteIs(route('posts.create'))
                ->assertSeeErrors([
                    'title' => 'El camp títol és obligatori',
                    'body' => 'El camp contingut és obligatori'
                ]);
        });
    }
}
