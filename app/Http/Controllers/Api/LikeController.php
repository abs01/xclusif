<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Http\Requests\LikeApiRequest;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $likes = Like::with(['user', 'post'])->get();

        return response()->json([
            'success' => true,
            'data' => $likes,
            'message' => 'Likes retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/likes
     * body: { "post_id": 1 }
     */
    public function store(LikeApiRequest $request)
    {
        $userId = auth('sanctum')->id();

        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        if (Like::where('user_id', $userId)->where('post_id', $request->post_id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Already liked'], 400);
        }

        $like = Like::create([
            'user_id' => $userId,
            'post_id' => $request->post_id,
        ]);

        return response()->json([
            'success' => true,
            'data' => $like,
            'message' => 'Like created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $like = Like::with(['user', 'post'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $like,
            'message' => 'Like retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LikeApiRequest $request, string $id)
    {
        $like = Like::findOrFail($id);
        $like->update(['post_id' => $request->post_id]);

        return response()->json([
            'success' => true,
            'data' => $like,
            'message' => 'Like updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/likes/{id}
     */
    public function destroy(string $id)
    {
        $like = Like::findOrFail($id);
        $like->delete();

        return response()->json([
            'success' => true,
            'message' => 'Like deleted successfully'
        ]);
    }
}

