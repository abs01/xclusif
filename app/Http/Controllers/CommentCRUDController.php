<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCRUDRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CommentCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'post']);

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by post
        if ($request->has('post_id') && $request->post_id) {
            $query->where('post_id', $request->post_id);
        }

        $comments = $query->orderBy('created_at', 'desc')->get();
        $users = User::all();
        $posts = Post::all();

        return view('comments.index', compact('comments', 'users', 'posts'));
    }

 
    /**
     * Display the specified resource.
     */
    public function show(Comment $comments)
    {
            $comments->load(['user', 'post']);
        return view('comments.show', compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comments)
    {
        try {
            $comments->delete();

            return redirect()->route('commentCRUD.index')
                ->with('success', 'Comentario eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('commentCRUD.index')
                ->with('error', 'Error al eliminar el comentario: ' . $e->getMessage());
        }
    }
}