<?php

class ShowPostTest extends FeatureTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    function test_a_user_can_see_the_post_details()
    {
    	// Having
    	$user = $this->defaultUser([
    		'name' => 'JhonatanCF'
		]);

        $post = $this->createPost([
        	'title'    => 'Como instalar Laravel',
        	'content'  => 'Este es el contenido del post',
            'user_id'  => $user->id
        ]);

        //When
        $this->visit($post->url)
            ->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see($user->name);
    }

    function test_old_urls_are_redirected($value='')
    {
        // Having
        $post = $this->createPost([
            'title'     => 'Old title'
        ]);

        $url = $post->url;
        $post->update(['title' => 'New Title']);

        //When
        $this->visit($url)
            ->seePageIs($post->url);
    }
}
