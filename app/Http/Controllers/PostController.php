<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user','category'])->withCount(['reactions','comments'])->latest()->get();
        return response()->json(['posts' => $posts]);
    }

    public function store(StorePostRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        if($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $path = $picture->store('upload/post-pic','public');
            $data['picture'] = $path;
        }

        $data['user_id'] = $user->id;

        $post = Post::create($data);
        $post->load(['user','category']);

        return response()->json(['post' => $post]);
    }
}
