<?php

namespace App\Http\Controllers;

use App\Models\Pay;
use Illuminate\Http\Request;
use App\Http\Requests\PayStoreRequest;
use App\Http\Requests\PayUpdateRequest;

class PayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pays = Pay::orderBy('id', 'asc')->get();
        return response()->json(['data' => $pays], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PayStoreRequest $request)
    {
        $pay = Pay::create($request->validated());
        return response()->json(['data' => $pay], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pay $pay)
    {
        return response()->json(['data' => $pay], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PayUpdateRequest $request, Pay $pay)
    {
        $pay->update($request->validated());
        return response()->json(['data' => $pay], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pay $pay)
    {
        $pay->delete();
        return response()->json(null, 204);
    }
}
