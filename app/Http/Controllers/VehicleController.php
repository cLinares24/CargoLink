<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleStoreRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::orderBy('id', 'asc')->get();

        return response()->json(['data' => $vehicles], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleStoreRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());

        return response()->json(['data' => $vehicle], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return response()->json(['data' => $vehicle], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleUpdateRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return response()->json(['data' => $vehicle], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->json(null, 204);
    }

    public function indexByTransportType($transport_type)
    {
        // Obtener los shipments con el estado especificado
        $vehicles = Vehicle::where('transport_type', $transport_type)->get();

        return response()->json(['data' => $vehicles], 200);
    }
}
