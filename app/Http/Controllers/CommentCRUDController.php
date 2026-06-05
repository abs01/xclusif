<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCRUDRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CommentCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Comment::with(['user', 'post']);



        $comments = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('comments.index', compact('comments'));
    }

 
    /**
     * Display the specified resource.
     */
  public function show(Comment $commentCRUD)
{
    $commentCRUD->load(['user', 'post']);
    return view('comments.show', ['comments' => $commentCRUD]);
}

    /**
     * Show the form for editing the specified resource.
     */

   
    /**
     * Remove the specified resource from storage.
     */
public function destroy(Comment $commentCRUD)
{
    try {
        $commentCRUD->delete();
        return redirect()->route('commentCRUD.index')
            ->with('success', 'Comentario eliminado exitosamente');
    } catch (Exception $e) {
        return redirect()->route('commentCRUD.index')
            ->with('error', 'Error al eliminar el comentario: ' . $e->getMessage());
    }
}
}