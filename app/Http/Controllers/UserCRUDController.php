<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserCRUDRequest;
use App\Models\Role;
use App\Models\Tier;
use Exception;

class UserCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
 $users = User::orderBy('role_id','asc')->orderBy('name','asc')->paginate(10);
        $roles = Role::orderBy('name','asc')->get();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $tiers = Tier::all();
        return view('users.create', compact('roles', 'tiers'));

    }

    /**
     * Store a newly created resource in storage.
     */
public function store(UserCRUDRequest $request)
{
    $validated = $request->validated();

    $validated['password'] = bcrypt($validated['password']);

    $user = User::create($validated);

           return redirect()->route('userCRUD.index')->with('success', 'User created successfully');

}

    /**
     * Display the specified resource.
     */
    public function show(User $userCRUD)
    {
        return view('users.show', compact('userCRUD'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $userCRUD)
    {
        $roles = Role::all();
        $tiers = Tier::all();
        return view('users.edit', compact('userCRUD', 'roles', 'tiers'));

    }

    /**
     * Update the specified resource in storage.
     */
public function update(UserCRUDRequest $request, User $userCRUD)
{
        $validated = $request->validated();

        $userCRUD->update($validated);

        return redirect()->route('userCRUD.show', $userCRUD)->with('success', 'User updated successfully');

}

//Funcion para verificar si el usuario es premium (tiene tier gold o diamond)
  public function isTierPremium(string $id){
        $user = User::findOrFail($id);
        if($user->tier->name === 'gold' || $user->tier->name === 'diamond'){
            return response()->json([
                'success' => true,
                'data' => true,
                'message' => "User is premium {$user->tier->name}"
            ]);
        }
        else{
            return response()->json([
                'success' => true,
                'data' => false,
                'message' => "User is not premium {$user->tier->name}"
            ]);
        }
  
    }

    /**
     * Remove the specified resource from storage.
     */
        public function destroy(User $userCRUD)
    {
        $user_role = Role::where('id', $userCRUD->role_id)->value('name');

        try {
            if (in_array($user_role, ["admin", "moderador"])) {
                throw new Exception('Usuario restringido de tipo ' . $user_role);
            }

            // Soft delete: change status to 'n'
            $userCRUD->status = 'n';

            
            // Detach meetings
            // $userCRUD->meetings()->detach();
            $userCRUD->followers()->detach();
            $userCRUD->following()->detach();
            $userCRUD->save();

            return redirect()->route('userCRUD.index')->with('success', 'User deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('userCRUD.index')->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
}
