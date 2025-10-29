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
            $name = time(). '.' . $picture->getClientOriginalExtension();
            $picture->move(public_path('upload/picture'),$name);
            $data['picture'] = 'picture/' . $name;
        }

        $data['user_id'] = $user->id;
        $post = Post::create($data);

        return response()->json(['post' => $post->only('id','title')]);
    }
}
