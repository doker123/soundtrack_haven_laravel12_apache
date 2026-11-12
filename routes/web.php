<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\TrackController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Public\PlaylistController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SettingsController;
use App\Http\Controllers\Public\AudioStreamController;

// Общедоступные страницы
Route::get("/", [HomeController::class, "index"])->name("home");
Route::get("/tracks/{track}/stream", [AudioStreamController::class,"stream",])->name("tracks.stream");
Route::view("/agreement", "public.agreement")->name("agreement");
// Авторизация в системе
Route::middleware("guest")->group(function () {
    Route::get("/login", [LoginController::class, "show"])->name("login");
    Route::post("/login", [LoginController::class, "store"]);

    Route::get("/register", [RegisterController::class, "show"])->name(
        "register",
    );
    Route::post("/register", [RegisterController::class, "store"]);
});
// Возможности пользователя в системе
Route::prefix("public")
    ->name("public.")
    ->middleware("auth")
    ->group(function () {
        Route::resource("playlists", PlaylistController::class);
        Route::post("playlists/{playlist}/tracks", [
            PlaylistController::class,
            "addTrack",
        ])->name("playlists.tracks.add");
        Route::delete("playlists/{playlist}/tracks/{track}", [
            PlaylistController::class,
            "removeTrack",
        ])->name("playlists.tracks.remove");
        Route::post("/logout", [LogoutController::class, "destroy"])->name(
            "logout",
        );

        Route::get("/settings", [SettingsController::class, "edit"])->name(
            "settings.edit",
        );

        // Отдельные маршруты обновлений
        Route::patch("/settings/name", [
            SettingsController::class,
            "updateName",
        ])->name("settings.name.update");
        Route::patch("/settings/email", [
            SettingsController::class,
            "updateEmail",
        ])->name("settings.email.update");
        Route::post("/settings/avatar", [
            SettingsController::class,
            "updateAvatar",
        ])->name("settings.avatar.update");
        Route::delete("/settings/avatar", [
            SettingsController::class,
            "deleteAvatar",
        ])->name("settings.avatar.delete");
        Route::patch("/settings/password", [
            SettingsController::class,
            "updatePassword",
        ])->name("settings.password.update");
        Route::post("/tracks/{track}/listen", [
            AudioStreamController::class,
            "recordHistory",
        ])->name("tracks.listen");
    });
// Админ панель системы
Route::prefix("admin")
    ->name("admin.")
    ->middleware(["auth", "admin"])
    ->group(function () {
        Route::resource("tracks", TrackController::class);
        Route::resource("authors", AuthorController::class);
        Route::resource("albums", AlbumController::class);
        Route::resource("users", UserController::class)->only([
            "index",
            "show",
            "update",
            "destroy",
        ]);
        Route::post("users/{user}/ban", [UserController::class, "ban"])->name(
            "users.ban",
        );
        Route::post("users/{user}/unban", [
            UserController::class,
            "unban",
        ])->name("users.unban");
    });
