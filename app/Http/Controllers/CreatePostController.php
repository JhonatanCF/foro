<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class CreatePostController extends Controller
{
    public function create()
    {
    	return view('posts.create');
    }

    public function store(Request $request)
    {
    	$post = new Post($request->all());

    	Auth::user()->posts()->save($post);

    	return $post->title;
    }
}
