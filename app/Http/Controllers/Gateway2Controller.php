<?php

namespace App\Http\Controllers;

use App\Http\Services\GatewaySService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Gateway2Controller extends Controller
{
    public function handleCallback(Request $request, GatewaySService $gatewaySService)
    {
        try {
            $gatewaySService->verifySignature($request);
            $gatewaySService->updateStatus($request);

            return response()->json(['success' => 'Payment was successes!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Payment not found'], 404);
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
