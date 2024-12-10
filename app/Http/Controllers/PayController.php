<?php

namespace App\Http\Controllers;

use App\Models\Pay;
use Illuminate\Http\Request;
use App\Http\Requests\PayStoreRequest;
use App\Http\Requests\PayUpdateRequest;

use App\Services\MercadoPagoService;

class PayController extends Controller
{

    protected $mercadoPagoService;

    public function __construct()
    {
        $this->mercadoPagoService = new MercadoPagoService();
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


        $response = $this->mercadoPagoService->createPaymentSession($validatedData['amount']);

        $responseData = $response->json();

        if ($response->successful()) {
            $transactionId = $responseData['id']; // Captura el transaction ID devuelto por Mercado Pago
            $paymentLink = $responseData['sandbox_init_point']; // URL para enviar al cliente

            // Guarda el transaction_id en la base de datos
            Pay::create([
                'shipment_id'=> $validatedData['shipment_id'],
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
        $data = $request->all();

        // Asegúrate de que el evento sea el que esperas
        if (isset($data['type']) && $data['type'] === 'payment') {
            $transactionId = $data['data']['id']; // ID de la transacción
            $status = $data['data']['status']; // Estado del pago
            $payment_method = $data['data']['transaction_details']['payment_method_id'];

            // Actualiza el estado del pago en la base de datos
            $pay = Pay::where('transaction_id', $transactionId)->first();
            if ($pay) {
                $pay->status = $status; // Actualiza el estado
                $pay->payment_method = $payment_method;
                $pay->save(); // Guarda los cambios
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

}
