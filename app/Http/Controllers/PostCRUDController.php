<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostMedia;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PostCRUDRequest;
use App\Http\Requests\GuardarImagenRequest;
use Exception;
use Illuminate\Support\Facades\File;

class PostCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user'])->paginate(10);
        $users = User::orderBy('name','asc')->get();

        return view('posts.index', compact('posts', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name','asc')->get();
        return view('posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCRUDRequest $request)
    {
        $validated = $request->validated();
        unset($validated['file_path']);

        $post = Post::create($validated);

        // Handle file upload if present
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = time() . '.' . $file->extension();
            $file->move(public_path('images'), $filename);

            PostMedia::create([
                'file_path' => $filename,
                'post_id' => $post->id,
            ]);
        }

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
        $postCRUD->load(['media']);
        $users = User::orderBy('name','asc')->get();

        return view('posts.edit', compact('postCRUD', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCRUDRequest $request, Post $postCRUD)
    {
        $validated = $request->validated();
        unset($validated['file_path']);

        $postCRUD->update($validated);

        // Handle file upload if present
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = time() . '.' . $file->extension();
            $file->move(public_path('images'), $filename);

            PostMedia::create([
                'file_path' => $filename,
                'post_id' => $postCRUD->id,
            ]);
        }

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

    /**
     * Store an image for the specified post.
     */
    public function image(GuardarImagenRequest $request, Post $postCRUD)
    {
        try {
            $file = $request->file('file_path');
            $filename = time() . '.' . $file->extension();
            $file->move(public_path('images'), $filename);

            $media = PostMedia::create([
                'file_path' => $filename,
                'post_id' => $postCRUD->id,
            ]);

            return redirect()->route('postCRUD.show', $postCRUD)
                ->with('success', 'Imagen subida correctamente');
        } catch (Exception $e) {
            return redirect()->route('postCRUD.show', $postCRUD)
                ->with('error', 'Error al subir imagen: ' . $e->getMessage());
        }
    }

    /**
     * Remove an image from storage.
     */
    public function destroyImage(PostMedia $media)
    {
        try {
            $mediaPath = public_path('images/' . $media->file_path);
            if (File::exists($mediaPath)) {
                File::delete($mediaPath);
            }

            $postId = $media->post_id;
            $media->delete();

            return redirect()->route('postCRUD.show', $postId)
                ->with('success', 'Imagen eliminada correctamente');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar imagen: ' . $e->getMessage());
        }
    }
}
