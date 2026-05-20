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


}
