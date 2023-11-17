<?php

namespace App\Http\Controllers;

use App\Http\Services\GatewayFService;
use Illuminate\Http\Request;

class Gateway1Controller extends Controller
{
    protected $service;

    public function __construct(GatewayFService $gatewayFService)
    {
        $this->service = $gatewayFService;
    }

    public function handleCallback(Request $request)
    {
        $expectedSignature = $this->service->hash($request);

        if (hash_equals($expectedSignature, $request['sign'])) {
            $this->service->processPayment($request, 1);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 'Invalid signature'], 400);
        }
    }
}
