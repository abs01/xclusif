<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Like::with(['user', 'post']);



        $likes = $query->paginate(10);

        return view('likes.index', compact('likes'));
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
