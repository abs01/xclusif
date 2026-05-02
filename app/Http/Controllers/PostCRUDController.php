<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PostCRUDRequest;
use Exception;

class PostCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user'])->paginate(10);
        $users = User::orderBy('name')->get();

        return view('posts.index', compact('posts', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCRUDRequest $request)
    {
        $validated = $request->validated();

        $post = Post::create($validated);

        return redirect()->route('postCRUD.index')->with('success', 'Post created successfully');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(Post $postCRUD)
    {
        $postCRUD->load(['user', 'comments', 'likes', 'media']);

        return view('posts.show', compact('postCRUD'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $postCRUD)
    {
        $users = User::orderBy('name')->get();

        return view('posts.edit', compact('postCRUD', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCRUDRequest $request, Post $postCRUD)
    {
        $validated = $request->validated();

        $postCRUD->update($validated);

        return redirect()->route('postCRUD.show', $postCRUD)->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $postCRUD)
    {
        try {
            $postCRUD->delete();

            return redirect()->route('postCRUD.index')->with('success', 'Post deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('postCRUD.index')->with('error', 'Error deleting post: ' . $e->getMessage());
        }
    }
}
