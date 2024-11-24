<?php

namespace App\Http\Controllers;

use App\Models\Transporter;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;

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
    public function store(Request $request)
    {
        //
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
    public function update(UserStoreRequest $request, Transporter $transporter)
    {
        $transporter->update($request->validated());
        return response()->json(['data' => $transporter], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transporter $transporter)
    {
        $transporter->delete();
        return response()->json(null, 204);
    }
}
