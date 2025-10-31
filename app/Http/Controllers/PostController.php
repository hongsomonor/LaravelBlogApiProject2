<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StorePostUpdateRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class,'post');
    }

    public function index()
    {
        $posts = Post::with(['user', 'category'])->withCount(['reactions', 'comments'])->latest()->get();
        return response()->json(['posts' => $posts]);
    }

    public function store(StorePostRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        if ($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $path = $picture->store('upload/post-pic', 'public');
            $data['picture'] = $path;
        }

        $data['user_id'] = $user->id;

        $post = Post::create($data);
        $post->load(['user', 'category']);

        return response()->json(['post' => $post]);
    }

    public function show(Post $post)
    {
        $post->load(['user','category'])->loadCount(['reactions','comments']);

        return response()->json([
            'success' => true,
            'post' => $post
        ]);
    }

    public function update(StorePostUpdateRequest $request, Post $post)
    {
        $data = $request->validated();

        if ($request->hasFile('picture')) {
            if ($post->picture) {
                Storage::disk('public')->delete($post->picture);
            }

            $picture = $request->file('picture');
            $path = $picture->store('upload/post-pic', 'public');
            $data['picture'] = $path;
        }

        $post->update($data);

        $post->load(['user', 'category'])->loadCount(['reactions', 'comments']);

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
            'post' => $post
        ], 200);
    }

    public function destroy(Post $post)
    {

        if ($post->picture) {
            Storage::disk('public')->delete($post->picture);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'deleted successfully'
        ], 200);
    }
}
