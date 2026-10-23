<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(StatusSeeder::class);

        $this->createAdmin();
    }

    /**
     * Create the admin account from .env credentials (idempotent).
     */
    private function createAdmin(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');

        // пропускаем, если админ уже создан раньше
        if (User::query()->where('email', $email)->exists()) {
            return;
        }

        // не привязываемся к захардкоженному id — ищем роль по имени
        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        if ($adminRole) {
            $adminRoleId = $adminRole->id;
        } else {
            $adminRoleId = DB::table('roles')->insertGetId([
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        User::create([
            'name' => env('ADMIN_NAME', 'Admin'),
            'email' => $email,
            'password' => Hash::make((string) env('ADMIN_PASSWORD', 'change-me')),
            'role_id' => $adminRoleId,
        ]);
    }
}
