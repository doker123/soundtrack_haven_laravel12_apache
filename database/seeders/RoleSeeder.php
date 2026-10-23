<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Базовые роли проекта.
     */
    private const ROLES = [
        ['name' => 'admin'],
        ['name' => 'user'],
    ];

    /**
     * Fill the roles table with base roles.
     */
    public function run(): void
    {
        $now = now();

        $rows = array_map(fn (array $role) => $role + [
            'created_at' => $now,
            'updated_at' => $now,
        ], self::ROLES);

        // upsert не создаёт дубликаты, если сидер запускают повторно
        DB::table('roles')->upsert($rows, ['name'], ['updated_at']);
    }
}
