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
		$category = factory(\App\Category::class)->create();

		//When: Lo que sucede, los eventos de la prueba
		$this->visit(route('posts.create'))
			->type($title, 'title')
			->type($content, 'content')
			->select($category->id, 'category_id')
			->press('Publicar');

		//Then: EL resultado que esperamos
		$this->seeInDatabase('posts', [
			'title' => $title,
			'content' => $content,
			'pending' => true,
			'user_id' => $user->id,
			'slug' => 'esta-es-una-pregunta',
			'category_id' => $category->id,
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
        $this->handleAuthenticationExceptions();

        $this->visit(route('posts.create'))
            ->seePageIs(route('token'));
    }

	function test_create_post_form_validation()
    {
        $this->handleValidationExceptions();

        $this->actingAs($this->defaultUser())
            ->visit(route('posts.create'))
            ->press('Publicar')
            ->seePageIs(route('posts.create'))
            ->seeErrors([
                'title' => 'El campo título es obligatorio',
                'content' => 'El campo contenido es obligatorio'
            ]);
    }
}