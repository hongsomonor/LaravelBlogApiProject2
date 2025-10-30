<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReactionRequest;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    // index
    public function index()
    {
        $reactions = Reaction::with(['user','post'])->get();

        return response()->json([
            'success' => true,
            'reactions' => $reactions
        ],200);
    }

    // store
    public function store(StoreReactionRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $data['user_id'] = $user->id;

        $reaction = Reaction::create($data);

        $reaction->load(['user','post']);

        return response()->json([
            'success' => true,
            'message' => 'Reaction successfully',
            'reaction' => $reaction
        ]);
    }
}
