<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function like(Post $post)
    {
        (! ! $post->isLiked) ? $post->unlike() : $post->like();

        if (request()->wantsJson()) {
            return $post->fresh();
        }

        return back();
    }

    public function dislike(Post $post)
    {
        (! ! $post->isDisLiked) ? $post->undislike() : $post->dislike();

        if (request()->wantsJson()) {
            return $post->fresh();
        }

        return back();
    }
}
