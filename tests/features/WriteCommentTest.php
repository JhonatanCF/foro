<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WriteCommentTest extends FeatureTestCase
{
    function test_a_user_can_write_a_comment()
    {
        $post = $this->createPost();

        //Usuario Conectado
		$this->actingAs($user = $this->defaultUser())
			->visit($post->url)
			->type('Un Comentario', 'comment')
			->press('Publicar comentario');

		$this->seeInDatabase('comments', [
			'comment' => 'Un Comentario',
			'user_id' => $user->id,
			'post_id' => $post->id,
		]);

		$this->seePageIs($post->url);
    }

    function test_write_form_comment_validation()
    {
        $post = $this->createPost();

    	$this->actingAs($this->defaultUser())
			->visit($post->url)
			->press('Publicar comentario')
			->seePageIs($post->url)
			->seeErrors([
				'comment' => 'El campo comentario es obligatorio'
			]);
    }
}
