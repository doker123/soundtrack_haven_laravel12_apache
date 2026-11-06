<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Ban;
use App\Http\Requests\Admin\BanUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = User::with([
            "role",
            "avatar",
            "bans" => fn($q) => $q->active(),
        ]);
        // Поиск по имени или email
        if ($search = $request->input("search")) {
            $query->where(function ($q) use ($search) {
                $q->where("name", "like", "%{$search}%")->orWhere(
                    "email",
                    "like",
                    "%{$search}%",
                );
            });
        }
        // Фильтр по роли
        if ($roleId = $request->input("role_id")) {
            $query->where("role_id", $roleId);
        }
        $users = $query->latest()->paginate(15)->withQueryString();
        $roles = Role::all();
        return view("admin.users.index", compact("users", "roles"));
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load([
            "role",
            "avatar",
            "bans.bannedBy",
            "favoriteTracks.author",
            "listeningHistory.track.author",
        ]);
        $roles = Role::all();

        return view("admin.users.show", compact("user"));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            "role_id" => ["required", "exists:roles,id"],
        ]);
        
        if (
            $user->is($request->user()) &&
            $user->hasRole("admin") &&
            $validated["role_id"] != $user->role_id
        ) {
            return back()->with(
                "error",
                "Вы не можете изменить роль собственного аккаунта.",
            );
        }
        $user->update(["role_id" => $validated["role_id"]]);
        return back()->with(
            "success",
            "Роль пользователя {$user->name} обновлена.",
        );   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->is($request->user())) {
            return back()->with("error", "Нельзя удалить самого себя.");
        }

        $user->delete();

        return redirect()
            ->route("admin.users.index")
            ->with("success", "Пользователь удален.");
    }

    public function ban(BanUserRequest $request, User $user)
    {
        if ($user->is($request->user())) {
            return back()->with("error", "Нельзя забанить самого себя.");
        }

        if ($user->hasRole("admin")) {
            return back()->with("error", "Нельзя забанить администратора.");
        }

        if ($user->isBanned()) {
            return back()->with("error", "Пользователь уже забанен.");
        }
        $user->bans()->create([
            "banned_by_id" => $request->user()->id,
            "reason" => $request->validated("reason"),
            "expires_at" => $request->validated("expires_at") ?? null,
        ]);
        return back()->with("success", "Пользователь {$user->name} забанен.");
    }

    public function unban(Request $request, User $user)
    {
        $activeBan = $user->activeBan();
        
        if (!$activeBan) {
            return back()->with("error", "У пользователя нет активного бана.");
        }

        $activeBan->update(["expires_at" => now()]);
        
        return back()->with("success", "Бан пользователя {$user->name} снят.");
    }
}
