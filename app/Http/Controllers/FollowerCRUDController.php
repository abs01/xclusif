<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        $followers = $user->followers()->with('tier')->get();
        return response()->json([
            'success' => true,
            'data' => $followers,
            'message' => 'Followers retrieved successfully'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        $request->validate([
            'following_id' => 'required|exists:users,id|different:follower_id',
        ]);
        if ($user->following()->where('following_id', $request->following_id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Already following'], 400);
        }
        $user->following()->attach($request->following_id, ['is_vip' => $request->is_vip ?? false]);
        return response()->json([
            'success' => true,
            'message' => 'Followed successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->with('tier')->get();
        return response()->json([
            'success' => true,
            'data' => $followers,
            'message' => 'Followers retrieved successfully'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        $request->validate([
            'is_vip' => 'boolean',
        ]);
        $user->following()->updateExistingPivot($id, ['is_vip' => $request->is_vip ?? false]);
        return response()->json([
            'success' => true,
            'message' => 'Follower updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        $user->following()->detach($id);
        return response()->json([
            'success' => true,
            'message' => 'Unfollowed successfully'
        ]);
    }
}
