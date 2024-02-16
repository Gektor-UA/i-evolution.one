<?php

namespace App\Http\Controllers;

use App\Services\WhitebitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BalanceController extends Controller
{










    /**
     * create or get deposit address for user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function depositAddress(Request $request)
    {
        $statusURL = 'https://' . $_SERVER['HTTP_HOST'] . "/cpayconfirm";
        $url = 'https://new.cryptocurrencyapi.net/api/trx/.give';
        $headers = [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*',
        ];
        $user = Auth::user();
        Log::info($statusURL);
        $body = [
            'key' => '05ab2cb093-c95cd057d6-6d8ddb4e40-9aa4c81fb7',
            'to' => 'TPrthZferdeenUNy93iLN5BX9f8GsvhtPm',
            'label' => $user->id,
            'statusURL' => $statusURL,
            'period'=> '30',
            'walletType' => $request->walletType ? $request->walletType : 1,
        ];
        $queryString = http_build_query($body);
        $urlWithParams = $url . '?' . $queryString;

        try {
            $response = Http::withHeaders($headers)->get($urlWithParams);
            Log::info($response->json());
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
