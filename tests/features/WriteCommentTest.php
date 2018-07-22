<?php

use Illuminate\Support\Facades\Notification;

class WriteCommentTest extends FeatureTestCase
{
    function test_a_user_can_write_a_comment()
    {
    	Notification::fake();

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

    function test_create_comment_form_validation()
    {
        $this->handleValidationExceptions();

        $post = $this->createPost();
        $user = $this->defaultUser();

        $this->actingAs($user)
            ->visit($post->url)
            ->press('Publicar comentario')
            ->seePageIs($post->url)
            ->seeErrors([
                'comment' => 'El campo comentario es obligatorio',
            ]);
    }
}
