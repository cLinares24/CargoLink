<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Client;

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
    public function store(UserStoreRequest $request, UserController $userController)
    {
        return $userController->store($request); // Delegar al UserController
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
    public function update(UserUpdateRequest $request, Client $client, UserController $userController)
    {
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

    public function getShipments(Client $client, UserController $userController)
    {
        // Obtiene los shipments asociados al client
        return $userController->getShipments($client);
    }
}
