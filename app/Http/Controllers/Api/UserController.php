<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\UserApiRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

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
public function update(UserApiRequest $request, User $user) // ← User model binding, not string
{

    $validated = $request->validated();

    if (!empty($validated['password'])) {
        $validated['password'] = bcrypt($validated['password']);
    } else {
        unset($validated['password']);           
        unset($validated['password_confirmation']);
    }

    $user->update($validated);

    return response()->json([
        'success' => true,
        'data'    => $user,
        'message' => 'User updated successfully'
    ]);
}

//Funcion para verificar si el usuario es premium (tiene tier gold o diamond)
  public function isTierPremium(User $user){
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
    public function destroy(User $user)
    {
        $user_role = Role::where('id', $user->role_id)->value('name');

        try {
            if (in_array($user_role, ["admin", "moderador"])) {
                throw new Exception('Usuario restringido de tipo ' . $user_role);
            }

            // Soft delete: change status to 'n'
            $user->status = 'n';

            // Delete comment images
            foreach ($user->comments as $comment) {
                $comment->status = 'n';
                $comment->save();
            }

            // Detach meetings
            // $user->meetings()->detach();
            $user->followers()->detach();
            $user->following()->detach();
            $user->save();

            return redirect()->route('userCRUD.index')->with('success', 'User deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('userCRUD.index')->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
}