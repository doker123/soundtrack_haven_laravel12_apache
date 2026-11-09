<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
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
        $user = $request->user()->load('avatar');

        return view('public.settings.edit', compact('user'));
    }

    public function updateName(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:50'],
        ], [
            'name.required' => 'Введите имя / никнейм.',
            'name.min' => 'Имя должно содержать минимум 2 символа.',
            'name.max' => 'Имя не должно превышать 50 символов.',
        ]);
        $request->user()->update([
            'name' => $validated['name'],
        ]);
        return back()->with('name_success', 'Имя успешно обновлено!');

    }

    public function updateEmail(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ], [
            'email.required' => 'Укажите адрес электронной почты.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'email.unique' => 'Этот email уже занят другим пользователем.',
        ]);
        if ($user->email !== $validated['email']) {
            $user->email_verified_at = null;
        }
        $user->email = $validated['email'];
        $user->save();
        return back()->with('email_success', 'Email успешно обновлен!');
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ], [
            'avatar.required' => 'Выберите файл изображения.',
            'avatar.image' => 'Файл должен быть изображением.',
            'avatar.mimes' => 'Поддерживаются форматы: JPG, PNG, WEBP.',
            'avatar.max' => 'Размер изображения не должен превышать 3 МБ.',
        ]);
        $user = $request->user();
        $file = $request->file('avatar');
        $path = $file->store('avatars', 'public');
        // Удаляем прежний файл аватара из хранилища и запись из БД
        if ($user->avatar) {
            if (Storage::disk($user->avatar->disk)->exists($user->avatar->path)) {
                Storage::disk($user->avatar->disk)->delete($user->avatar->path);
            }
            $user->avatar->delete();
        }
        $avatar = Avatar::create([
            'original_name' => $file->getClientOriginalName(),
            'extension'     => $file->getClientOriginalExtension(),
            'file_size'     => $file->getSize(),
            'disk'          => 'public',
            'path'          => $path,
        ]);
        $user->avatar_id = $avatar->id;
        $user->save();
        return back()->with('avatar_success', 'Аватар успешно обновлен!');

    }
    public function deleteAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user->avatar) {
            if (Storage::disk($user->avatar->disk)->exists($user->avatar->path)) {
                Storage::disk($user->avatar->disk)->delete($user->avatar->path);
            }
            $user->avatar->delete();
            $user->avatar_id = null;
            $user->save();
        }
        return back()->with('avatar_success', 'Аватар удален.');
    }
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Введите текущий пароль.',
            'current_password.current_password' => 'Неверный текущий пароль.',
            'password.required' => 'Введите новый пароль.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min' => 'Новый пароль должен быть не короче 8 символов.',
        ]);
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        return back()->with('password_success', 'Пароль успешно изменен!');
    }
}
