<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Transporter;

class TransporterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listar todos los transportadores
        $transporters = Transporter::orderBy('id', 'asc')->get();

        return response()->json(['data' => $transporters], 200);
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
    public function show(Transporter $transporter)
    {
        return response()->json(['data' => $transporter], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, Transporter $transporter, UserController $userController)
    {
        return $userController->update($request, $transporter);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transporter $transporter)
    {
        $transporter->delete();

        return response()->json(null, 204);
    }

    public function getVehicles(Transporter $transporter)
    {
        // Obtiene los packages asociados al shipment
        $vehicles = $transporter->vehicles;

        return response()->json(['data' => $vehicles], 200);
    }

    public function getShipments(Transporter $transporter, UserController $userController)
    {
        // Obtiene los shipments asociados al transporter
        return $userController->getShipments($transporter);
    }
}
