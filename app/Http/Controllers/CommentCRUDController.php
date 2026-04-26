<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCRUDRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentCRUDController extends Controller
{
    /**
     * GET /api/posts/{post}/comments
     */
    public function index(Post $post)
    {
        $comments = $post->comments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return CommentResource::collection($comments)
            ->additional(['meta' => 'Comentarios obtenidos correctamente']);
    }

    /**
     * GET /api/comments/{comment}
     */
    public function show(Comment $comment)
    {
        $comment->load(['user', 'post']);

        return (new CommentResource($comment))
            ->additional(['meta' => 'Comentario obtenido correctamente']);
    }

    /**
     * POST /api/comments
     */
    public function store(CommentCRUDRequest $request)
    {
        $validated = $request->validated();

        $comment = Comment::create([
            'content'  => $validated['content'],
            'user_id'  => Auth::id(),
            'post_id'  => $validated['post_id'],
        ]);

        $comment->load(['user', 'post']);

        return (new CommentResource($comment))
            ->additional(['meta' => 'Comentario creado correctamente']);
    }

    /**
     * PUT /api/comments/{comment}
     */
    public function update(CommentCRUDRequest $request, Comment $comment)
    {
        // Only allow the owner to update
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $comment->update($request->validated());

        $comment->load(['user', 'post']);

        return (new CommentResource($comment))
            ->additional(['meta' => 'Comentario actualizado correctamente']);
    }

    /**
     * DELETE /api/comments/{comment}
     */
    public function destroy(Comment $comment)
    {
        // Only allow the owner (or admin) to delete
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $comment->delete();

        return response()->json(['meta' => 'Comentario eliminado correctamente']);
    }

}