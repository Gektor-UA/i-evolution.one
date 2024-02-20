<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purse;
use App\Models\Transaction;
use App\Models\Video;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $videos = Video::with('user')
            ->whereNull('is_approved')
            ->get();

        $withdraws = Withdraw::all();

        return view('admin.main',[
            'videos' => $videos,
            'withdraws' => $withdraws
        ]);
    }

    public function updateStatus($withdrawId, Request $request)
    {
        $withdraw = Withdraw::find($withdrawId);
        if (!$withdraw) {
            return response()->json(['error' => 'Withdraw not found'], 404);
        }

        // Оновлення статусу
        if ($request->status === 'confirm') {
            $withdraw->status = Withdraw::STATUS_CONFIRM;
            Transaction::create([
            'user_id' => $withdraw->user_id,
            'type_transaction' => Transaction::WITHDRAWAL,
            'purses_type' => Purse::I_HEALTH_PURSE,
            'amount' => -$withdraw->amount,
        ]);
        } elseif ($request->status === 'cancelled') {
            $withdraw->status = Withdraw::STATUS_CANCELLED;
            $usePurse = Purse::where('user_id', $withdraw->user_id)->first();
            $usePurse->amount += $withdraw->amount;
            $usePurse->save();
        }
        $withdraw->save();

        return response()->json(['message' => 'Withdraw status updated successfully']);
    }
}
