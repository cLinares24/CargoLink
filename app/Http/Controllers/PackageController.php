<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageStoreRequest;
use App\Http\Requests\PackageUpdateRequest;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::orderBy('id', 'asc')->get();
        return response()->json(['data' => $packages], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageStoreRequest $request)
    {
        $package = Package::create($request->validated());
        return response()->json(['data' => $package], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        return response()->json(['data' => $package], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageUpdateRequest $request, Package $package)
    {
        $package->update($request->validated());
        return response()->json(['data' => $package], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return response()->json(null, 204);
    }
}
