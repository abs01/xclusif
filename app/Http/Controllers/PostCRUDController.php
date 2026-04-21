<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostCRUDRequest;

class PostCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user', 'comments', 'likes', 'media'])->get();

        return response()->json([
            'success' => true,
            'data' => $posts,
            'message' => 'Posts retrieved successfully'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Create post form'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCRUDRequest $request)
    {

        $post = Post::create($request);

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'Post created successfully'
        ], 201);
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with(['user', 'comments', 'likes', 'media'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'Post retrieved successfully'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'Post data for editing'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCRUDRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        $validated = $request->validated();

        $post->update($validated);

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'Post updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    }
}
