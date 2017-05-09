<?php

/**
*
*/
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
			'user_id' => $user->id
		]);

		// Test a user is redirected to the posts details after creating it.
		$this->see($title);
	}
}