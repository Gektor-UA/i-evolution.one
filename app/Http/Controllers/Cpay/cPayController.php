<?php


namespace App\Http\Controllers\Cpay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

//62aafc0d26-33d5fc0e55-6245a36030-00d5c00c27 - ключ А
class cPayController extends Controller
{
    public function cPaySend(Request $request)
    {
        // $url = 'https://new.cryptocurrencyapi.net/api/trx/.acceptUSDT';
        $url = 'https://new.cryptocurrencyapi.net/api/trx/.give';
        $headers = [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*',
            // Add any other headers as needed
        ];
        $body = [
//            'key' => 'f76b636493-fc34b2c3ea-71bf450ab4-3f7d4a73a6',
//            'key' => 'd8b4e2800e-40be489dec-834aec2fe9-be7065ab1b',
            'key' => '62aafc0d26-33d5fc0e55-6245a36030-00d5c00c27',
//            'to' => 'TJwekUJx9cbE4dfeUs1aFMUequWbWRRDsn',
            'to' => 'TPrthZferdeenUNy93iLN5BX9f8GsvhtPm',
            'label' => $request->input('label'),
            'statusURL' => $request->input('statusURL'),
            'period'=> '30'
            // Add other data as needed
        ];
        $queryString = http_build_query($body);
        $urlWithParams = $url . '?' . $queryString;
//        try {
//            // Perform the GET request using Http facade
//            // $response = Http::withHeaders($headers)->post($url, $body);
//            $response = Http::withHeaders($headers)->get($urlWithParams);
//            // Assuming you want to return the response as JSON
//            return response()->json($response->json(), $response->status());
//        } catch (\Exception $e) {
//            // Handle errors if any
//            return response()->json(['error' => $e->getMessage()], 500);
//        }
    }

}

