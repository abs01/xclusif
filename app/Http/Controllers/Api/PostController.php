<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarImagenRequest;
use App\Http\Requests\PostCRUDRequest;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->with(['user', 'comments', 'likes', 'media'])->get();

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
        $validated = $request->validated();
        $validated['user_id'] = auth('sanctum')->id();

        $post = Post::create($validated);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('post_media', 'public/images');

                PostMedia::create([
                    'post_id' => $post->id,
                    'media_path' => $path,
                ]);
            }
        }

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
     * Store an image for the specified resource.
     */
  public function image(GuardarImagenRequest $request, Post $post)
{
try {
    $file = $request->file('file_path');
    $filename = time() . '.' . $file->extension();
    $file->move(public_path('images'), $filename);

    $media = PostMedia::create([
        'file_path' => $filename,
        'post_id'   => $post->id,
    ]);

    return response()->json([
        'success' => true,
        'data'    => $media,
        'message' => 'Imagen subida correctamente'
    ], 201);
} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Error uploading image: ' . $e->getMessage()
    ], 500);
}
} 
/**
     * Remove an image from storage.
     */
  public function destroyImage(PostMedia $media)
{
    $mediaPath = public_path('images/' . $media->file_path);
    if (File::exists($mediaPath)) {
        File::delete($mediaPath);
    }

    $media->delete();

    return response()->json([
        'success' => true,
        'message' => 'Imagen eliminada correctamente'
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
