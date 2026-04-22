<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Requests\LikeCRUDRequest;

class LikeCRUDController extends Controller
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Create like form'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LikeCRUDRequest $request)
    {
        $request->validated();

        $userId = auth()->id();

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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $like = Like::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $like,
            'message' => 'Like data for editing'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LikeCRUDRequest $request, string $id)
    {
        $like = Like::findOrFail($id);

        $request->validate();

        $like->fill($request->only(['post_id']));
        $like->save();

        return response()->json([
            'success' => true,
            'data' => $like,
            'message' => 'Like updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
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
