<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreCommentUpdateRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Comment::class, 'comment');
    }

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
            $path = $picture->store('upload/comment-pic','public');
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

    public function show(Comment $comment)
    {
        $comment->load(['user','post']);

        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }

    public function update(StoreCommentUpdateRequest $request,Comment $comment)
    {
        $data = $request->validated();

        if($request->hasFile('picture')) {
            if($comment->picture) {
                Storage::disk('public')->delete($comment->picture);
            }

            $picture = $request->file('picture');
            $path = $picture->store('upload/comment-pic','public');
            $data['picture'] = $path;
        }

        $comment->load(['user','post']);

        return response()->json([
            'success' => true,
            'message' => 'update success',
            'comment' => $comment
        ]);
    }

    public function destroy(Comment $comment)
    {
        if($comment->picture) {
            Storage::disk('public')->delete($comment->picture);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete comment success',
        ],200);
    }
}
