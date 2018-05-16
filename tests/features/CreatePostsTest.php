<?php

use App\Post;

class CreatePostsTest extends FeatureTestCase
{
	function test_a_user_create_a_post()
	{
		//Having: Tenemos una pregunta
		$title = 'Esta es una pregunta';
		$content = 'Este es el contenido';

		//Usuario Conectado
		$this->actingAs($user = $this->defaultUser());

		//When: Lo que sucede, los eventos de la prueba
		$this->visit(route('posts.create'))
			->type($title, 'title')
			->type($content, 'content')
			->press('Publicar');

		//Then: EL resultado que esperamos
		$this->seeInDatabase('posts', [
			'title' => $title,
			'content' => $content,
			'pending' => true,
			'user_id' => $user->id,
			'slug' => 'esta-es-una-pregunta',
		]);

		$post = Post::first();

        // Test the author is suscribed automatically to the post.
        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);


		// Test a user is redirected to the posts details after creating it.
		$this->seePageIs($post->url);
	}

	function test_creating_a_post_requires_authentication()
	{
		// When
		$this->visit(route('posts.create'));

		// Then
		$this->seePageIs(route('token'));
	}

	function test_creating_post_form_validation()
	{
		$this->actingAs($this->defaultUser())
			->visit(route('posts.create'))
			->press('Publicar')
			->seePageIs(route('posts.create'))
			->seeErrors([
				'title' 	=> 'El campo título es obligatorio',
				'content' 	=> 'El campo contenido es obligatorio'
			]);
	}
}