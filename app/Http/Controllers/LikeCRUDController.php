<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\LikeCRUDRequest;

class LikeCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Like::with(['user', 'post']);

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by post
        if ($request->has('post_id') && $request->post_id) {
            $query->where('post_id', $request->post_id);
        }

        $likes = $query->get();
        $users = User::all();
        $posts = Post::all();

        return view('likes.index', compact('likes', 'users', 'posts'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $like = Like::with(['user', 'post'])->findOrFail($id);

        return view('likes.show', compact('like'));
    }


}
