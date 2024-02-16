<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Purse;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\Refill;
use App\Models\Deposit;
use App\Models\Transactions;
use App\Models\PromoCode;
use App\Services\WhitebitService;
use App\Http\Requests\Balance\WithdrawRequest;
use App\Http\Requests\Balance\DepositRequest;
use App\Mail\ProfileCodeMail;
use App\Mail\ReplenishmentMail;
use App\Mail\WithdrawalMail;
use App\Mail\WithdrawalNotificationMail;
use App\Mail\WithdrawalNotificationUserMail;

class BalanceController2 extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected WhitebitService $whitebitService
    )
    {
        $this->middleware('auth');
    }

    /**
     * get page data by ajax
     *
     * @return json
     */
    public function getData(Request $request)
    {
        $dateCondition = session('balance') ? '<=' : '>=';
        $balanceData =  '2024-01-15';
        $transactionsList = Transactions::select('type', 'amount', 'created_at')->where('user_id', '=', Auth::user()->id)
                    ->where('created_at', $dateCondition, $balanceData)
                    ->orderBy('created_at', 'desc')->limit(4)->get();

        $transactionsLang = Transactions::TRANSACTIONS_LANG;
        foreach ($transactionsList as &$transaction) {
            $transaction->type = $transactionsLang[$transaction->type];
        }

        return response()->json([
            'balanceTransactionsList' => $transactionsList,
        ]);
    }

    /**
     * withdrawal money through whitebit service
     *
     * @return json
     */
    public function withdraw(WithdrawRequest $request)
    {

        // Перевірка чи є введений промокод
        // ВАЖЛИВО!!! треба задати PROMO_FIRST саме той код який буде перевірятися
        $user = Auth::user();
        /*$minWithdrawAmount = PromoCode::where('user_id', $user->id)
            ->where('code', Withdraw::PROMO_FIRST)
            ->exists();
        $hasPromoCodeCustomFrom100 = PromoCode::where('user_id', Auth::user()->id)
            ->where('code', 'like', '%' . Withdraw::PROMO_DEPOSIT_FROM_100 . '%')
            ->first();

        // Якщо true то використовуємо MIN_AMOUNT_PROMO інакше використовуємо MIN_AMOUNT
        $minWithdrawAmount = $minWithdrawAmount || $hasPromoCodeCustomFrom100 ? Withdraw::MIN_AMOUNT_PROMO : Withdraw::MIN_AMOUNT;

        // Check Is Promo Code Created By Admin
        $hasPromoCodeFromAdmin = PromoCode::where('promo_codes.user_id', Auth::user()->id)
            ->join('all_promo_codes', 'all_promo_codes.code_value', '=', 'promo_codes.code')
            ->whereNotNull('all_promo_codes.created_by')
            ->first();
        if (!empty($hasPromoCodeFromAdmin['min_withdraw'])) {
            $minWithdrawAmount = $hasPromoCodeFromAdmin['min_withdraw'];
        }*/

        $minWithdrawAmount = Withdraw::NEW_MIN_AMOUNT;
        $validatedData = $request->validated();

        $Purse = Purse::where('user_id', '=', Auth::user()->id)->where('wallet_type', $request->walletType)->first();


        if (empty($Purse) || $Purse->amount < $validatedData['amount']) {
            return response()->json(['message' => "Not enough money!"], 400);
        }
//        if ($validatedData['amount'] < Withdraw::MIN_AMOUNT) {
        if ($validatedData['amount'] < $minWithdrawAmount) {
            return response()->json(['message' => "Minimum withdrawal amount is: " . $minWithdrawAmount . "!"], 400);
        }
        if ($request->paymentType !== '3') {
            if (empty($validatedData['emailCode']) || $validatedData['emailCode'] != session('withdraw_code')) {
                return response()->json(['message' => "Confirmation code is wrong!"], 400);
            }
        }
        $withdrawSum = Withdraw::select(DB::raw('SUM(amount) as amount'))->where('user_id', Auth::user()->id)
                ->where('status', Refill::STATUS_PENDING)->where('wallet_type', $request->walletType)->first();
        if ($Purse->amount < $withdrawSum['amount'] + $validatedData['amount']) {
            return response()->json(['message' => "Max withdrawal amount is bigger than balance!"], 400);
        }


        $new_Purse_percent = false;
        $newPurse = false;
        $oldPurse = Purse::where('user_id', '=', Auth::user()->id)->where('wallet_type', Purse::OLD_PURSE)->first();
        if($request->walletType === '1') {
            if($Purse->percent === 0) {
                return response()->json(['message' => "You cannot withdraw funds!"], 400);
            }
            if($Purse->amount <= 100) {
                if((int)$validatedData['amount'] !== 10)  return response()->json(['message' => "You can withdraw only 10$!"], 400);
                $new_Purse_percent = 0;
            } else {
                $percent_amount = $Purse->amount * ($Purse->percent / 100);
                if($validatedData['amount'] > $percent_amount) return response()->json(['message' => "You cannot withdraw more than allow!"], 400);
                $new_Purse_percent = $Purse->percent - $validatedData['amount'] * 100 / $Purse->amount;
            }
            if ($new_Purse_percent === 0 || ($new_Purse_percent > 0 && $new_Purse_percent < 0.01)) {
                $new_Purse_percent = floor($new_Purse_percent);
            }
        }
        if ($request->paymentType === '3' && $request->walletType === '1') {
            $newPurse = Purse::where('user_id', '=', Auth::user()->id)->where('wallet_type', Purse::NEW_PURSE)->first();
            if (empty($newPurse)) {
                Purse::create([
                    'user_id' => Auth::user()->id,
                    'wallet_type' => Purse::NEW_PURSE,
                    'amount' =>  0,
                ]);
            }
            $newPurse->amount += $validatedData['amount'];
            $newPurse->save();
        } else {
            Withdraw::create([
                'user_id' => Auth::user()->id,
                'amount'  => $validatedData['amount'],
                'wallet'  => $validatedData['address'],
                'status'  => Refill::STATUS_PENDING,
                'payment_method' => Withdraw::PAYMENT_USDT_TRC,
                'wallet_type' => $request->walletType,
            ]);
        }

        if($request->walletType === '2') {
            Purse::where('user_id',Auth::user()->id)
                ->where('wallet_type', $request->walletType)->update([
                    'amount'  => $Purse->amount - $validatedData['amount'],
                ]);
        } else {
            Purse::where('user_id',Auth::user()->id)
                ->where('wallet_type', $request->walletType)->update([
                    'amount'  => $Purse->amount - $validatedData['amount'],
                    'percent'  => $new_Purse_percent,
                ]);
        }


        if ($request->paymentType !== '3') {
            session()->forget('emailCode');

            Mail::to(Auth::user()->email)->send(
                new WithdrawalNotificationUserMail( Auth::user()->toArray() )
            );

            if (config('mail.adminEmail')) {
                Mail::to(config('mail.adminEmail'))->send(
                    new WithdrawalNotificationMail([])
                );
            }
        }

        $available_amount = $request->walletType === '1'?
            floor(($Purse->amount - (float)($validatedData['amount'])) * $new_Purse_percent/ 100) :
            floor(($oldPurse->amount) * $oldPurse->percent/ 100)
        ;

        return response()->json([
            'success' => "Withdraw Created!",
            'amount' =>floor(($Purse->amount - $validatedData['amount']) * 100) / 100 ,
            'new_percent' => $new_Purse_percent,
            'type' => $request->walletType,
            'available_amount' => $available_amount,
            'paymentType' => $request->paymentType,
            'new_purse_amount' =>isset($newPurse->amount) ? floor(($newPurse->amount) * 100) / 100 : false,
        ]);
    }

    /**
     * send withdrawal confirmation code
     *
     * @return json
     */
    public function withdrawCode()
    {
        $data = Auth::user();
        $str  = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz123456789';
        $data['code'] = '';
        for ($i = 1; $i <= 8; $i++) {
            $data['code'] .= $str[rand(0, strlen($str)-1)];
        }
        Mail::to($data['email'])->send(
            new ProfileCodeMail( array_merge($data->toArray(), ['type' => 'withdraw']) )
        );
        session(["withdraw_code" => $data['code']]);

        return response()->json(['success' => "Message with code was sent!"]);
    }

    /**
     * create or get deposit address for user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function depositAddress(Request $request)
    {
//        dd($request->all());
        $statusURL = 'https://' . $_SERVER['HTTP_HOST'] . "/cpayconfirm";
        $url = 'https://new.cryptocurrencyapi.net/api/trx/.give';
        $headers = [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*',
            // Add any other headers as needed
        ];
        $user = Auth::user();
        Log::info($statusURL);
        $body = [
//            'key' => 'f76b636493-fc34b2c3ea-71bf450ab4-3f7d4a73a6',
//            'key' => 'd8b4e2800e-40be489dec-834aec2fe9-be7065ab1b',
            'key' => '05ab2cb093-c95cd057d6-6d8ddb4e40-9aa4c81fb7',
//            'to' => 'TJwekUJx9cbE4dfeUs1aFMUequWbWRRDsn',
            'to' => 'TPrthZferdeenUNy93iLN5BX9f8GsvhtPm',
            'label' => $user->id,
            'statusURL' => $statusURL,
            'period'=> '30',
            'walletType' => $request->walletType ? $request->walletType : 1,
            // Add other data as needed
        ];
        $queryString = http_build_query($body);
        $urlWithParams = $url . '?' . $queryString;
        try {
            $response = Http::withHeaders($headers)->get($urlWithParams);
            Log::info($response->json());
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            // Handle errors if any
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * deposit money through whitebit service
     *
     * @return json
     */
    public function deposit(DepositRequest $request)
    {
        $validatedData = $request->validated();

        $responceURL = $this->whitebitService->depositURL($validatedData['amount'], $validatedData['paymentType']);
        return !empty($responceURL) ? response()->json(['responceURL' => $responceURL]) :
                                      response()->json(['message' => "Something went wrong! Please try again."], 400);
    }

}
