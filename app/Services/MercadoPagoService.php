<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MercadoPagoService
{
    protected $baseUrl = 'https://api.mercadopago.com/';
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');
    }

    /**
     * Crear el pago con Mercado Pago y devolver el enlace
     */
    public function createPaymentSession($amount)
    {
        $response = Http::withToken($this->accessToken)->post(
            $this->baseUrl . 'checkout/preferences',
            [
                "items" => [
                    [
                        "id" => "Envio",
                        "title" => "Compra de prueba",
                        "quantity" => 1,
                        "currency_id" => "COP", // Cambiar según tu moneda
                        "unit_price" => $amount,
                    ]
                ],
                "back_urls" => [
                    "success" => "https://www.mercadopago.com.co/",
                    "failure" => "https://www.mercadopago.com.co/",
                    "pending" => "https://www.mercadopago.com.co/",
                ],
            ]
        );

        
        return $response;
    }
}
