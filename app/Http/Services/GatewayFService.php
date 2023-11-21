<?php

namespace App\Http\Services;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GatewayFService
{
    public function hash($request)
    {
        $sortedParams = collect($request)->except('sign')->sortKeys();
        $stringToHash = implode(':', array_map('rawurlencode', $sortedParams->toArray())).':KaTf5tZYHx4v7pgZ';

        return hash('sha256', $stringToHash);
    }

    public function processPayment($data, $gateway)
    {
        $user = User::find(1);
        $dailyLimit = $gateway == 1 ? 1000 : 2000;
        $dailyPayments = $user->payments()->sum('amount');
        if ($dailyPayments >= $dailyLimit) {
            return $user->payments()->save(new Payment(['amount' => $data['amount'], 'status' => $data['status']]));
        } else {
            Log::info("Daily payment limit exceeded for user {$user->id} from gateway {$gateway}");

            return false;
        }
    }
}
