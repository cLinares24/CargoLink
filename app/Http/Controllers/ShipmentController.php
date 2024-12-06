<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Http\Requests\ShipmentStoreRequest;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipment = Shipment::orderBy('id', 'asc')->get();
        return response()->json(['data' => $shipment], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShipmentStoreRequest $request)
    {
        $shipment = Shipment::create($request->validated());
        return response()->json(['data' => $shipment], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        return response()->json(['data' => $shipment], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShipmentStoreRequest $request, Shipment $shipment)
    {
        $shipment->update($request->validated());
        return response()->json(['data' => $shipment], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return response()->json(null, 204);
    }
}
