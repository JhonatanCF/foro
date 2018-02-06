<?php

use App\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostIntegrationTest extends TestCase
{
	use DatabaseTransactions;

    public function test_a_slug_is_generated_and_saved_to_the_database()
    {
    	$user = $this->defaultUser();

    	$post = factory(\App\Post::class)->make([
        	'title' => 'Como instalar Laravel',
        	'content' => 'Este es el contenido del post'
        ]);

		$user->posts()->save($post);

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
}
