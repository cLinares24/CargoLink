<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayStoreRequest;
use App\Http\Requests\PayUpdateRequest;
use App\Models\Pay;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;

class PayController extends Controller
{
    protected $mercadoPagoService;

    public function __construct()
    {
        $this->mercadoPagoService = new MercadoPagoService;
    }

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
        $validatedData = $request->validated();

        $response = $this->mercadoPagoService->createPaymentSession($validatedData['shipment_id'], $validatedData['amount']);

        $responseData = $response->json();

        if ($response->successful()) {
            $transactionId = $responseData['id']; // Captura el transaction ID devuelto por Mercado Pago
            $paymentLink = $responseData['init_point']; // URL para enviar al cliente

            // Guarda el transaction_id en la base de datos
            Pay::create([
                'shipment_id' => $validatedData['shipment_id'],
                'transaction_id' => $transactionId,
                'status' => 'pending',
                'amount' => $validatedData['amount'],
            ]);

            return response()->json([
                'payment_link' => $paymentLink,
            ], 201);
        }

        return response()->json([
            'error' => 'No se pudo crear el enlace de pago',
            'details' => $responseData,
        ], 400);
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

    public function webhook(Request $request)
    {
        // Verifica la firma si es necesario (opcional, pero recomendado)
        // $this->verifySignature($request);

        // Obtén los datos del webhook
        $webhook_data = $request->all();

        // Asegúrate de que el evento sea el que esperas
        if (isset($webhook_data['type']) && $webhook_data['type'] === 'payment') {
            $payment_id = $webhook_data['data']['id']; // ID de la transacción

            $response = $this->mercadoPagoService->getPayment($payment_id);

            $payment_data = $response->json();

            if ($response->successful()) {
                $shipment_id = $payment_data['external_reference'];
                $status = $payment_data['status'];
                $payment_method = $payment_data['payment_method']['type'];

                $pay = Pay::where('shipment_id', $shipment_id)->first();
                if ($pay) {
                    $pay->status = $status; // Actualiza el estado
                    $pay->payment_method = $payment_method;
                    $pay->save(); // Guarda los cambios

                    return response()->json(['data' => $pay], 200);
                }

                return response()->json([
                    'error' => 'No se encontro el pay asociado a shipment',
                    'details' => $payment_data,
                ], 404);
            }
        }

        return response()->json([
            'error' => 'No se encontro el payment de mercado pago.',
            'details' => $payment_data,
        ], 400);

    }
}
