<?php

namespace App\Http\Controllers;

use App\Models\Program;
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

        // Перевірка чи вже було списання
        $firstWithdrawalExists = ProgramsUser::where('user_id', $userId)
            ->whereNotNull('first_withdrawal')
            ->whereNull('payment_program')
            ->exists();

        // Якщо списання було, блокуємо вибір нової програми
        if ($firstWithdrawalExists) {
            return response()->json(['message' => 'Неможливо змінити програму після першого списання'], 403);
        }

        // Перевірка чи вже є запис про вибір програми користувачем
        $programUser = ProgramsUser::where('user_id', $userId)
            ->whereNull('payment_program')
            ->first();

        if ($programUser) {
            // Якщо запис вже є, оновлюємо його
            $programUser->update([
                'program_id' => (int) $validatedData['package_id'],
            ]);
        } else {
            // Якщо запису немає, створюємо новий
            ProgramsUser::create([
                'user_id' => $userId,
                'program_id' => (int) $validatedData['package_id'],
            ]);
        }

        Video::where('user_id', $userId)
            ->where('is_program', null)
            ->update(['is_program' => 0]); // Встановлюємо позначку, що до цього відео вибрано програму "0"

        return response()->json(['message' => 'Вибрану програму збережено успішно'], 200);
    }

    // Метод для отримання даних про вибрану програму
    public function getSelectedProgram(Request $request)
    {
        $userId = Auth::id();

        $programUser = ProgramsUser::where('user_id', $userId)
            ->whereNull('payment_program')
            ->first();

        if ($programUser) {
            $program = Program::find($programUser->program_id);

            if ($program) {
                return response()->json(['program' => $program]);
            } else {
                return response()->json(['error' => 'Дані про програму не знайдено'], 404);
            }
        } else {
            return response()->json(['error' => 'Програма не вибрана'], 404);
        }
    }
}
