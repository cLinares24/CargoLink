<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Http\Requests\ShipmentStoreRequest;
use App\Http\Requests\ShipmentUpdateRequest;
use App\Services\GeocodingService;
use PhpOption\None;

class ShipmentController extends Controller
{

    protected $geocodingService;

    public function __construct(GeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener los parámetros de ordenamiento desde la solicitud
        $sortBy = $request->query('sort_by', 'id'); // Campo por el que se ordena (por defecto 'id')
        $sortOrder = $request->query('sort_order', 'asc'); // Orden (por defecto 'asc')
    
        // Validar que el campo de ordenamiento sea válido
        $validSortFields = ['id', 'name', 'created_at', 'updated_at']; // Campos válidos para ordenar
        if (!in_array($sortBy, $validSortFields)) {
            return response()->json(['error' => 'Invalid sort field'], 400);
        }
    
        // Validar que el orden sea válido
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            return response()->json(['error' => 'Invalid sort order'], 400);
        }
    
        // Obtener los shipments ordenados según los parámetros
        $shipments = Shipment::orderBy($sortBy, $sortOrder)->get();
    
        return response()->json(['data' => $shipments], 200);
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
    public function update(ShipmentUpdateRequest $request, Shipment $shipment)
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

    public function setStatus(Request $request, Shipment $shipment)
    {
        $status = $request->input('status');
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');

        if (!$status) {
            return response()->json(['error' => 'El estado es requerido'], 400);
        }

        if ($status === 'shipped') {

            if ($lat && $lng) {
                $geocodeResult = $this->geocodingService->reverseGeocode($lat, $lng);

                if (!isset($geocodeResult['error'])) {
                    $shipment->status = $status;
                    $shipment->current_address = $geocodeResult['address'];
                    $shipment->save();

                    return response()->json(['data' => $shipment], 200);
                }

                return response()->json(['error' => $geocodeResult['error']], 400);
            }

            return response()->json(['error' => 'Coordenadas inválidas'], 400);
        }

        // Actualiza solo el estado si no es "shipped"
        $shipment->status = $status;
        $shipment->current_address = NULL;
        $shipment->save();

        return response()->json(['data' => $shipment], 200);
    }

    public function getStatus(Shipment $shipment)
    {
        $status = $shipment->status;
        $address = $shipment->current_address;

        if ($status === 'shipped' && $address) {
            $geocodeResult = $this->geocodingService->geocode($address);

            if (!isset($geocodeResult['error'])) {
                return response()->json([
                    'status' => $status,
                    'address' => $address,
                    'latitude' => $geocodeResult['lat'],
                    'longitude' => $geocodeResult['lng'],
                ], 200);
            }

            return response()->json(['error' => $geocodeResult['error']], 400);
        }

        return response()->json(['status' => $status], 200);
    }

    public function getPackages(Shipment $shipment)
    {
        // Obtiene los packages asociados al shipment
        $packages = $shipment->packages;

        return response()->json(['data' => $packages], 200);
    }

    public function getPay(Shipment $shipment)
    {
        // Obtiene los packages asociados al shipment
        $pay = $shipment->pay;

        return response()->json(['data' => $pay], 200);
    }

    public function getReview(Shipment $shipment)
    {
        // Obtiene los packages asociados al shipment
        $review = $shipment->review;

        return response()->json(['data' => $review], 200);
    }

    public function indexByStatus($status)
    {
        // Obtener los shipments con el estado especificado
        $shipments = Shipment::where('status', $status)->get();

        return response()->json(['data' => $shipments], 200);
    }
}
