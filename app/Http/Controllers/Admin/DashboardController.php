<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Author;
use App\Models\BanAppeal;
use App\Models\Playlist;
use App\Models\Track;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Главная страница панели администратора со счётчиками системы.
     */
    public function index()
    {
        // 1. Счётчики записей
        $tracksCount = Track::count();
        $playlistsCount = Playlist::count();
        $albumsCount = Album::count();
        $authorsCount = Author::count();
        $usersCount = User::count();

        // 2. Счётчик активных пользователей
        // Сессия считается активной, если пользователь проявлял активность за последние 15 минут
        $activeThreshold = now()->subMinutes(15)->timestamp;

        $onlineUsersCount = DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '>=', $activeThreshold)
            ->distinct('user_id')
            ->count('user_id');

        // Количество не заблокированных (активных по статусу) пользователей
        $unbannedUsersCount = User::whereDoesntHave('bans', function ($q) {
            $q->active();
        })->count();

        // Дополнительно: ожидающие рассмотрения апелляции
        $pendingAppealsCount = BanAppeal::where('status', 'pending')->count();

        return view('admin.dashboard.index', compact(
            'tracksCount',
            'playlistsCount',
            'albumsCount',
            'authorsCount',
            'usersCount',
            'onlineUsersCount',
            'unbannedUsersCount',
            'pendingAppealsCount'
        ));
    }
}
