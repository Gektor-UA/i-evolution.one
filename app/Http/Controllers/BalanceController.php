<?php

namespace App\Http\Controllers;

use App\Models\Purse;
use App\Models\Transaction;
use App\Models\Withdraw;
use App\Services\WhitebitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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






    /**
     * withdrawal money through whitebit service
     *
     * @return json
     */
    public function withdraw(Request $request)
    {
        $user = Auth::user();

        $amount = $request->input('amount');
        $wallet = $request->input('wallet');

        Transaction::create([
            'user_id' => $user->id,
            'type_transaction' => Transaction::WITHDRAWAL,
            'purses_type' => Purse::I_HEALTH_PURSE,
            'amount' => $amount,
        ]);

        Withdraw::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'wallet_type' => Purse::I_HEALTH_PURSE,
            'status' => Withdraw::STATUS_PENDING,
            'wallet' => $wallet
        ]);

        // Відправка електронного листа адміністратору для підтвердження
//        Mail::to('admin@example.com')->send(new WithdrawalNotificationMail($user, $amount, $wallet));

        // Повернення успішної відповіді
        return response()->json(['message' => 'Запрос на вывод средств успешно отправлен']);
    }

}
