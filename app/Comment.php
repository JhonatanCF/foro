<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	use CanBeVoted;

    protected $fillable = ['comment', 'post_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function post()
	{
		return $this->belongsTo(Post::class);
	}

	function markAsAnswer()
	{
		$this->post->pending = false;
		$this->post->answer_id = $this->id;
		$this->post->save();
	}

	public function getAnswerAttribute()
    {
        return $this->id === $this->post->answer_id;
    }
}
