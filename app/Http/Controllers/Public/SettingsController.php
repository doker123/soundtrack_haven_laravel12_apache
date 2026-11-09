<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Settings\UpdateAvatarRequest;
use App\Http\Requests\Public\Settings\UpdateEmailRequest;
use App\Http\Requests\Public\Settings\UpdateNameRequest;
use App\Http\Requests\Public\Settings\UpdatePasswordRequest;
use App\Models\Avatar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user()->load("avatar");

        return view("public.settings.edit", compact("user"));
    }

    public function updateName(UpdateNameRequest $request): RedirectResponse
    {
        $request->user()->update([
            "name" => $request->validated("name"),
        ]);

        return back()->with("name_success", "Имя успешно обновлено!");
    }

    public function updateEmail(UpdateEmailRequest $request): RedirectResponse
    {
        $user = $request->user();
        $newEmail = $request->validated("email");

        if ($user->email !== $newEmail) {
            $user->email_verified_at = null;
        }

        $user->email = $newEmail;
        $user->save();

        return back()->with("email_success", "Email успешно обновлен!");
    }

    public function updateAvatar(UpdateAvatarRequest $request): RedirectResponse
    {
        $user = $request->user();
        $file = $request->file("avatar");
        $path = $file->store("avatars", "public");

        if ($user->avatar) {
            if (
                Storage::disk($user->avatar->disk)->exists($user->avatar->path)
            ) {
                Storage::disk($user->avatar->disk)->delete($user->avatar->path);
            }
            $user->avatar->delete();
        }
        $avatar = Avatar::create([
            "original_name" => $file->getClientOriginalName(),
            "extension" => $file->getClientOriginalExtension(),
            "file_size" => $file->getSize(),
            "disk" => "public",
            "path" => $path,
        ]);
        $user->avatar_id = $avatar->id;
        $user->save();

        return back()->with("avatar_success", "Аватар успешно обновлен!");
    }
    public function deleteAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user->avatar) {
            if (
                Storage::disk($user->avatar->disk)->exists($user->avatar->path)
            ) {
                Storage::disk($user->avatar->disk)->delete($user->avatar->path);
            }
            $user->avatar->delete();
            $user->avatar_id = null;
            $user->save();
        }
        return back()->with("avatar_success", "Аватар удален.");
    }
    public function updatePassword(
        UpdatePasswordRequest $request,
    ): RedirectResponse {
        $request->user()->update([
            "password" => Hash::make($request->validated("password")),
        ]);

        return back()->with("password_success", "Пароль успешно изменен!");
    }
}
