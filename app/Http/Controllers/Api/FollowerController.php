<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
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

        public function makeVip(string $id)
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        $follow = $user->following()->where('following_id', $id)->first();
        if (!$follow) {
            return response()->json(['success' => false, 'message' => 'Not following this user'], 400);
        }
        $follow->pivot->is_vip = true;
        $follow->pivot->save();
        return response()->json([
            'success' => true,
            'message' => 'User marked as VIP successfully'
        ]);
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

    public function getFollowing(string $id)
    {
        $user = User::findOrFail($id);
        $following = $user->following()->with('tier')->get();
        return response()->json([
            'success' => true,
            'data' => $following,
            'message' => 'Following retrieved successfully'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
public function destroy(string $id)
{
    $user = auth('sanctum')->user();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    $user->following()->detach($id);

    return response()->json([
        'success' => true,
        'message' => 'Unfollowed successfully'
    ]);
}
}
