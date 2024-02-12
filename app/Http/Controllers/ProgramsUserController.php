<?php

namespace App\Http\Controllers;

use App\Models\ProgramsUser;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramsUserController extends Controller
{
    /**
     * Збереження вибраної програми користувачем.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function savePackage(Request $request)
    {
        $validatedData = $request->validate([
            'package_id' => 'required|integer',
        ]);

        $userId = Auth::id();

        ProgramsUser::create([
            'user_id' => $userId,
            'program_id' => (int) $validatedData['package_id'],
        ]);

        Video::where('user_id', $userId)
            ->where('is_program', null)
            ->update(['is_program' => 0]); // Встановлюємо позначку, що до цього відео вибрано програму "0"

        return response()->json(['message' => 'Вибрану програму збережено успішно'], 200);
    }
}
