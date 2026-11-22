<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BanAppeal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BanAppealController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('status', 'pending');

        $query = BanAppeal::with(['user.avatar', 'ban.bannedBy', 'reviewedBy']);

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $appeals = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'all' => BanAppeal::count(),
            'pending' => BanAppeal::where('status', 'pending')->count(),
            'approved' => BanAppeal::where('status', 'approved')->count(),
            'rejected' => BanAppeal::where('status', 'rejected')->count(),
        ];

        return view('admin.appeals.index', compact('appeals', 'status', 'counts'));
    }

    public function approve(Request $request, BanAppeal $appeal)
    {
        if (!$appeal->isPending()) {
            return back()->with('error', 'Эта апелляция уже была рассмотрена ранее.');
        }

        $validated = $request->validate([
            'admin_comment' => ['nullable', 'string', 'max:1000'],
        ]);

        // 1. Снимаем активный бан
        $ban = $appeal->ban;
        if ($ban && $ban->isActive()) {
            $ban->update([
                'expires_at' => now(),
            ]);
        }

        // 2. Обновляем статус апелляции
        $appeal->update([
            'status' => 'approved',
            'reviewed_by_id' => $request->user()->id,
            'admin_comment' => $validated['admin_comment'] ?? 'Апелляция одобрена. Бан снят.',
            'reviewed_at' => now(),
        ]);

        return back()->with('success', "Пользователь {$appeal->user->name} успешно разбанен.");
    }

    public function reject(Request $request, BanAppeal $appeal)
    {
        if (!$appeal->isPending()) {
            return back()->with('error', 'Эта апелляция уже была рассмотрена ранее.');
        }

        $validated = $request->validate([
            'admin_comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $appeal->update([
            'status' => 'rejected',
            'reviewed_by_id' => $request->user()->id,
            'admin_comment' => $validated['admin_comment'] ?? 'В разбане отказано.',
            'reviewed_at' => now(),
        ]);

        return back()->with('success', "Апелляция пользователя {$appeal->user->name} отклонена.");
    }
}
