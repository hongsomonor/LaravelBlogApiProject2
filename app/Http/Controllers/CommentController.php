<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // show all
    public function index()
    {
        $comments = Comment::with(['user','post'])->latest()->get();

        return response()->json([
            'sucess' => true,
            'comments' => $comments
        ]);
    }

    // store
    public function store(StoreCommentRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        if($request->hasFile('picture')){
            $picture = $request->file('picture');
            $path = $picture->store('comment-pic','public');
            $data['picture'] = $path;
        }

        $data['user_id'] = $user->id;
        $comment = Comment::create($data);
        $comment->load(['user','post']);

        return response()->json([
            'success' => true,
            'message' => 'Comment created successfully',
            'comment' => $comment
        ]);
    }
}
