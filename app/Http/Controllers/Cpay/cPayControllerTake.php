<?php


namespace App\Http\Controllers\Cpay;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Purse;
use App\Models\Refill;
use App\Mail\ReplenishmentMail;


class cPayControllerTake extends Controller
{


    public function cPayCon(Request $request)
    {

        try {
            $amount = $request->input('amount');
            $label = $request->input('label');
            $walletType = $request->input('walletType');
            $confirmation = $request->input('confirmation');
            Log::info("--------------------");
            Log::info("Payment is started!");
            Log::info(now() . "-------- UserId:" . $label);
            if ($confirmation == 1 || $confirmation == '1') {
            $user = User::find($label);
            // Создаем транзакцию с запросом на вывод
//            Transaction::create([
//                'user_id'                       => $user->id,
//                'transaction_type_id'           => TransactionsTypesConsts::INVEST_TYPE_ID,
//                'wallet_id'                     => 1,
//                'amount_crypto'                 => $amount,
//
//                'amount_usd'                    => $amount,
//                'balance_usd_after_transaction' => $user->balance_usd + $request->amount,
//                'rate'                          => 1,
//                'commission'                    => 0,
//                'editor_id'                     => $user->id,
//            ]);
//            $user->balance_usd =  $user->balance_usd + $amount;
//            $user->save();
                $Purse = Purse::where('user_id', '=', $user['id'])->where('wallet_type',Purse::I_HEALTH_PURSE)->first();
            Purse::where('user_id', $user['id'])
                ->where('wallet_type',Purse::I_HEALTH_PURSE)
                ->update([
                'amount' => $Purse['amount'] + floatval($amount),
            ]);
//            Refill::create([
//                'user_id' => $user['id'],
//                'amount'  => floatval($amount),
//                'status'  => Refill::STATUS_CONFIRM,
//                'payment_method' => Refill::PAYMENT_USDT_TRC,
//                'hash'    => "",
//                'transactionId' => "",
//            ]);
                Log::info("Payment is success!");
            try {
                Mail::to($user['email'])->send(
                    new ReplenishmentMail([
                        'amount' => number_format($amount, 2),
                        'email' => $user['email'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                    ])
                );
            }catch(\Exception $e) {
                Log::info('Email send error: ' . json_encode($e));
            }
                Log::info("--------------------");
            return response()->json("ok", 200);
        } else {
                Log::info("--------------------");
            return response()->json("not ok", 200);
        }

        } catch (\Exception $e) {
            // Handle errors if any
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}

