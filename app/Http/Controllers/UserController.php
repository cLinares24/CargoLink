<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Transporter;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los usuarios
        $users = User::orderBy('id', 'asc')->get();
        
        // Retornar los usuarios en formato JSON
        return response()->json(['data' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->validated());
         // Determinar el tipo de usuario
        $type = $request->input('type'); // 'client' o 'transporter'

        if ($type === 'client') {
            $user = Client::create($request->validated());
        } elseif ($type === 'transporter') {
            $user = Transporter::create($request->validated());
        } else {
            return response()->json(['error' => 'Invalid user type'], 400);
        }
        
        return response()->json(['data' => $user], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Retornar los datos del usuario
        return response()->json(['data' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStoreRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json(['data' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
