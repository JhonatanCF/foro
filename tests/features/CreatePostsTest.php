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

	function test_creating_a_post_requires_authentication()
	{
		// When
		$this->visit(route('posts.create'));

		// Then
		$this->seePageIs(route('login'));
	}

	function test_creating_post_form_validation()
	{
		$this->actingAs($this->defaultUser())
			->visit(route('posts.create'))
			->press('Publicar')
			->seePageIs(route('posts.create'))
			->seeInElement('#field_title .help-block', 'El campo título es obligatorio')
			->seeInElement('#field_content .help-block', 'El campo contenido es obligatorio');
	}
}