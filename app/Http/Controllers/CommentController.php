<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreCommentUpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{

    public function __construct()
    {
        // $this->authorizeResource(Comment::class, 'comment');
    }

    // show all
    public function index()
    {
        $this->authorize('viewAny',Comment::class);

        $comments = Comment::with(['user','post'])->latest()->get();

        return response()->json([
            'sucess' => true,
            'comments' => $comments
        ]);
    }

    // store
    public function store(StoreCommentRequest $request)
    {
        $this->authorize('create',Comment::class);
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
        $this->authorize('view',$comment);

        $comment->load(['user','post']);

        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }

    public function update(StoreCommentUpdateRequest $request, string $comment)
    {
        // Manually retrieve the model instance using the ID string from the route
        $commentModel = Comment::findOrFail($comment);

        // Manually authorize the update action
        $this->authorize('update', $commentModel);

        $data = $request->validated();

        if ($request->hasFile('picture')) {
            // Delete old picture if exists
            if ($commentModel->picture) {
                Storage::disk('public')->delete($commentModel->picture);
            }

            $picture = $request->file('picture');
            $path = $picture->store('upload/comment-pic', 'public');
            $data['picture'] = $path;
        }

        // Remove the post_id from the data array before updating to avoid unintended changes
        unset($data['post_id']);

        $commentModel->update($data);

        $commentModel->load(['user', 'post']);

        return response()->json([
            'success' => true,
            'message' => 'update success',
            'comment' => $commentModel
        ]);
    }

    public function destroy(string $comment)
    {
        // Manually retrieve the model instance
        $commentModel = Comment::findOrFail($comment);

        // Manually authorize the delete action
        $this->authorize('delete', $commentModel);

        if ($commentModel->picture) {
            Storage::disk('public')->delete($commentModel->picture);
        }

        $commentModel->delete();

        return response()->json([
            'success' => true,
            'message' => 'delete comment success',
        ], 200);
    }
}
