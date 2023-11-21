<?php

namespace App\Http\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class GatewaySService
{
    public function verifySignature($request)
    {
        try {
            $calculatedSignature = md5(implode('.', $request->toArray()).env('P_APP_KEY'));
            abort_if($calculatedSignature !== $request->header('Authorization'), 403, 'Invalid signature');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return false;
        }
    }

    public function updateStatus($request)
    {
        return Payment::whereIn('id', [$request->invoice])->update([
            'status' => $request->status,
        ]);
    }
}
