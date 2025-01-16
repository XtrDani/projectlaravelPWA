<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function showAllPosts()
    {
        $posts = Post::with('user', 'comments.user')->latest()->get();
        return view('all-posts', ['posts' => $posts]);
    }


    public function deletePost(Post $post)
    {
        if (auth()->user()->id === $post['user_id']) {
            $post->delete();
        }
        return redirect('/');
    }

    public function updatePost(Post $post, Request $request)
    {
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);
        return redirect('/');
    }

    public function showEditScreen(Post $post)
    {
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        return view('edit-post', ['post' => $post]);
    }

    public function createPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
        Post::create($incomingFields);
        return redirect('/');
    }

    public function addComment(Request $request, Post $post)
    {
        $incomingFields = $request->validate([
            'body' => 'required'
        ]);

        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['post_id'] = $post->id;
        $incomingFields['user_id'] = auth()->id();
        Comment::create($incomingFields);
        return redirect('/all-posts');
    }

    //////////////////////

    public function upvote(Post $post)
    {
        $existingVote = $post->votes()->where('user_id', auth()->id())->first();

        if ($existingVote) {
            $existingVote->update(['is_upvote' => true]);
        } else {
            $post->votes()->create([
                'user_id' => auth()->id(),
                'is_upvote' => true,
            ]);
        }

        return back();
    }

    public function downvote(Post $post)
    {
        $existingVote = $post->votes()->where('user_id', auth()->id())->first();

        if ($existingVote) {
            $existingVote->update(['is_upvote' => false]);
        } else {
            $post->votes()->create([
                'user_id' => auth()->id(),
                'is_upvote' => false,
            ]);
        }

        return back();
    }


}
