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
        $posts = Post::with(['user:id,name,profile','category:id,name'])->withCount(['reactions','comments'])->latest()->get();
        return response()->json(['posts' => $posts]);
    }

    public function store(StorePostRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        if($request->hasFile('picture')) {
            $picture = $request->file('picture');
            // $name = time(). '.' . $picture->getClientOriginalExtension();
            // $picture->move(public_path('upload/picture'),$name);
            $path = $picture->store('public','post-pic');
            $data['picture'] = $path;
        }
        $post = Post::create($data);
        $post->load(['user','category']);

        return response()->json(['post' => $post->only('id','title')]);
    }
}
