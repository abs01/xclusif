<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\UserCRUDRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(["role"])
                    ->where('status', 'y')
                    ->orderBy('role_id')
                    ->orderBy('id')
                    ->get();        
        return response()->json([
            'success' => true,
            'data' => $users,
            'message' => 'Users retrieved successfully'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Create user form'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(UserCRUDRequest $request)
{
    $validated = $request->validated();

    $validated['password'] = bcrypt($validated['password']);

    $user = User::create($validated);

    return response()->json([
        'success' => true,
        'data' => $user,
        'message' => 'User created successfully'
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::with('tier', 'posts', 'comments', 'likes')->findOrFail($user->id);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User retrieved successfully'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User data for editing'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
public function update(UserCRUDRequest $request, string $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validated();

    if (isset($validated['password'])) {
        $validated['password'] = bcrypt($validated['password']);
    }

    $user->update($validated);

    return response()->json([
        'success' => true,
        'data' => $user,
        'message' => 'User updated successfully'
    ]);
}

//Funcion para verificar si el usuario es premium (tiene tier gold o diamond)
  public function isTierPremium(string $id){
        $user = User::findOrFail($id);
        if($user->tier->name === 'gold' || $user->tier->name === 'diamond'){
            return response()->json([
                'success' => true,
                'is_premium' => true,
                'message' => 'User is premium'
            ]);
        }
        else{
            return response()->json([
                'success' => true,
                'is_premium' => false,
                'message' => 'User is not premium'
            ]);
        }
  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}