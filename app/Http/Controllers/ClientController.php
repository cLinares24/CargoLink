<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::orderBy('id', 'asc')->get();
        return response()->json(['data' => $clients], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, UserController $userController)
    {
        $request->merge(['type' => 'client']);
        return $userController->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return response()->json(['data' => $client], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStoreRequest $request, Client $client, UserController $userController)
    {
        $request->merge(['type' => 'client']);
        return $userController->update($request, $client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(null, 204);
    }
}
