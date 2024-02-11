<?php

namespace App\Http\Controllers;

use App\Models\Purse;
use App\Models\ReferralsUser;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Закинути відео на сервер
     * @param $request - дані про відео
     */
    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required_without:youtubeLink|mimes:mp4,mov,avi,wmv,flv',
            'youtubeLink' => 'required_without:video|url',
            'user_id' => 'required|integer',
        ]);

        if ($request->hasFile('video')) {
            // Завантаження відео
            $videoPath = $request->file('video')->store('videos', 'public');
            // Збереження відео у базі даних
            Video::create([
                'user_id' => $request->user_id,
                'file_path' => $videoPath,
                'is_sent' => true,
            ]);
        }

        if ($request->filled('youtubeLink')) {

            $youtubeLink = $request->input('youtubeLink');

            // Якщо посилання має формат https://youtu.be/
            if (Str::startsWith($youtubeLink, 'https://youtu.be/')) {
                $videoId = Str::after($youtubeLink, 'https://youtu.be/');
                // Якщо посилання має формат https://www.youtube.com/watch?v=
            } else if (Str::startsWith($youtubeLink, 'https://www.youtube.com/watch?v=')) {
                $videoId = Str::after($youtubeLink, 'https://www.youtube.com/watch?v=');
            } else {
                return redirect()->back()->with('error', 'Неправильний формат посилання на YouTube');
            }
            $embedLink = 'https://www.youtube.com/embed/' . $videoId;
            Video::create([
                'user_id' => $request->user_id,
                'video_url' => $embedLink,
                'is_sent' => true,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Завантажити відео
     * @param $id - id відео
     */
    public function downloadVideo($id)
    {
        $video = Video::find($id);
        if (!$video) {
            abort(404);
        }

        $filePath = storage_path('app/public/'.$video->file_path);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $video->file_name);
    }

    /**
     * Підтвердити відео
     * @param $id - id відео
     * @param $request - id користувача
     */
    public function approveVideo($id, Request $request)
    {

        Video::findOrFail($id)->update(['is_approved' => 1]);
        $this->processBonus($request->user_id);

        return redirect()->back()->with('success', 'Відео підтверджено');
    }

    /**
     * Відхилити відео
     * @param $id - id відео
     */
    public function rejectVideo($id)
    {
        Video::findOrFail($id)->update(['is_approved' => 0]);

        return redirect()->back()->with('success', 'Відео відхилено');
    }

    /**
     * Метод нараховує 1 раз бонус в 20$ за підтвердження відео якщо
     * у користувача, який відправив відео батько є амбасадором
     * @param $user_id - id користувача
     */
    public function processBonus($user_id)
    {
        // Знаходимо баланс користувача
        $user = User::where('id', $user_id)->first();
        $userBalanse = Purse::where('user_id', $user_id)->first();

        // Перевірка чи є амбасадором користувач який відправив відео
        $userAuth = $this->isAmbassador($user_id);

        // Перевірка чи є амбасадором батько користувача, якого відправив відео
        $userRef = ReferralsUser::where('user_id', $user_id)->first();
        $userParent = $userRef ? $this->isAmbassador($userRef->referral_id) : false;

        // Перевірка умов для нарахування бонусу
        if (!$userAuth && $userParent && $user->bonus_processed !== true) {
            // Перевірка, чи нарахування вже було здійснено
            if (!$user->bonus_processed) {
                // Нарахування бонусу
                $userBalanse->update(['amount' => $userBalanse->amount + Video::BONUS_VIDEO]);
                $user->update(['bonus_processed' => $user->bonus_processed = true]);
            }
            Transaction::create([
                'user_id' => $user_id,
                'amount' => Video::BONUS_VIDEO,
                'type_transaction' => Transaction::SINGLE_REFERRAL_BONUS,
                'purses_type' => Purse::I_HEALTH_PURSE
            ]);
        }
    }

    /**
     * Метод перевіряє чи є користувач амбасадор
     * @param $user_id - id користувача
     * @return bool - чи є амбасадор
     */
    protected function isAmbassador($user_id) {
        $user = User::where('id', $user_id)->first();

        if ($user->is_ambassador == 1) {
            return true;
        }
        return false;
    }
}
