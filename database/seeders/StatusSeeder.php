<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
         * Базовые статусы для треков/альбомов/плейлистов.
         */
    private const STATUSES = [
        ['name' => 'draft',     'display_name' => 'Черновик'],
        ['name' => 'published', 'display_name' => 'Опубликовано'],
        ['name' => 'unlisted',  'display_name' => 'По ссылке'],
        ['name' => 'blocked',   'display_name' => 'Заблокировано'],
    ];
    public function run(): void
    {
        DB::table('statuses')->upsert(self::STATUSES, ['name'], ['display_name']);
    }
}
