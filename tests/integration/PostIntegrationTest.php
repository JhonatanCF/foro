<?php

use App\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostIntegrationTest extends TestCase
{
	use DatabaseTransactions;

    function test_a_slug_is_generated_and_saved_to_the_database()
    {
        $post = $this->createPost([
            'title' => 'Como instalar Laravel',
        ]);

        $this->assertSame(
            'como-instalar-laravel',
            $post->fresh()->slug
        );

        /* --Cumplen la misma funcion que el assert same
        $this->seeInDatabase('posts', [
            'slug' => 'como-instalar-laravel'
        ]);

        $this->assertSame('como-instalar-laravel', $post->slug);
        */

    }

    function test_url_post_is_generated_correctly()
    {
        // Having
        $user = $this->defaultUser();
        $post = factory(\App\Post::class)->make();

        // When
        $user->posts()->save($post);

        //Then
        $this->assertSame($post->url, route('posts.show', [$post->id, $post->slug]));
    }
}
