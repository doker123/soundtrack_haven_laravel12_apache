<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\BanAppeal;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->isBanned()) {
            return redirect()->route('home');
        }

        $activeBan = $user->bans()->active()->latest()->first();

        // Получаем последнюю апелляцию пользователя по текущему бану
        $latestAppeal = $activeBan 
            ? BanAppeal::where('ban_id', $activeBan->id)->latest()->first() 
            : null;

        return view('public.banned', compact('user', 'activeBan', 'latestAppeal'));
    }

    public function appeal(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->isBanned()) {
            return redirect()->route('home');
        }

        $activeBan = $user->bans()->active()->latest()->first();
        if (!$activeBan) {
            return redirect()->route('home');
        }

        // Проверяем, нет ли уже апелляции в статусе pending
        $hasPending = BanAppeal::where('ban_id', $activeBan->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            return back()->with('error', 'Ваша предыдущая заявка ещё находится на рассмотрении администрации.');
        }

        $validated = $request->validate([
            'reason' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'reason.required' => 'Пожалуйста, опишите причину обжалования.',
            'reason.min' => 'Сообщение должно содержать не менее 10 символов.',
            'reason.max' => 'Сообщение не должно превышать 2000 символов.',
        ]);

        BanAppeal::create([
            'user_id' => $user->id,
            'ban_id' => $activeBan->id,
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return back()->with('status', 'Ваше заявление на обжалование успешно отправлено и принято на рассмотрение администрацией.');
    }
}
