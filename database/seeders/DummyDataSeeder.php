<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Author;
use App\Models\Role;
use App\Models\Status;
use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRole = Role::firstOrCreate(["name" => "user"]);
        $adminUser = User::whereHas(
            "role",
            fn($q) => $q->where("name", "admin"),
        )->first();
        $publishedStatus =
            Status::where("name", "published")->first() ?? Status::first();
        $draftStatus =
            Status::where("name", "draft")->first() ?? $publishedStatus;
        // 1. Создаем 25 тестовых пользователей (для проверки пагинации users)
        for ($i = 1; $i <= 25; $i++) {
            $user = User::firstOrCreate(
                ["email" => "user{$i}@example.com"],
                [
                    "name" => "Тестовый Юзер {$i}",
                    "password" => Hash::make("password"),
                    "role_id" => $userRole->id,
                ],
            );
            // Нескольким пользователям выдадим тестовые баны (один бессрочный, один временный)
            if ($i === 2 && $adminUser && !$user->isBanned()) {
                $user->bans()->create([
                    "banned_by_id" => $adminUser->id,
                    "reason" => "Спам в комментариях",
                    "expires_at" => null, // Бессрочный бан
                ]);
            }
            if ($i === 3 && $adminUser && !$user->isBanned()) {
                $user->bans()->create([
                    "banned_by_id" => $adminUser->id,
                    "reason" => "Оскорбления других участников",
                    "expires_at" => now()->addDays(7), // Временный бан
                ]);
            }
        }
        // 2. Список известных игровых композиторов
        $composers = [
            [
                "name" => "Mick Gordon",
                "bio" =>
                    "Австралийский композитор, наиболее известный по саундтрекам DOOM (2016) и DOOM Eternal.",
            ],
            [
                "name" => "Akira Yamaoka",
                "bio" =>
                    "Японский композитор и саунд-дизайнер, написавший легендарную музыку к серии Silent Hill.",
            ],
            [
                "name" => "Jeremy Soule",
                "bio" =>
                    "Американский композитор, автор саундтреков The Elder Scrolls (Morrowind, Oblivion, Skyrim).",
            ],
            [
                "name" => "Marcin Przybyłowicz",
                "bio" =>
                    "Польский композитор, главный автор музыки к The Witcher 3: Wild Hunt и Cyberpunk 2077.",
            ],
            [
                "name" => "Gustavo Santaolalla",
                "bio" =>
                    "Аргентинский музыкант и композитор, двукратный лауреат «Оскара», автор музыки к The Last of Us.",
            ],
            [
                "name" => "Darren Korb",
                "bio" =>
                    "Штатный композитор Supergiant Games (Bastion, Transistor, Hades, Hades II).",
            ],
            [
                "name" => "Austin Wintory",
                "bio" =>
                    'Композитор Journey, The Banner Saga и Assassin\'s Creed Syndicate.',
            ],
            [
                "name" => "Jesper Kyd",
                "bio" =>
                    'Датский композитор, написавший саундтреки к ранним частям Assassin\'s Creed и серии Hitman.',
            ],
            [
                "name" => "Gareth Coker",
                "bio" =>
                    "Британский композитор, автор саундтреков Ori and the Blind Forest и Halo Infinite.",
            ],
            [
                "name" => "Christopher Larkin",
                "bio" =>
                    "Композитор, создавший меланхоличную музыку к культовой метроидвании Hollow Knight.",
            ],
            [
                "name" => "Koji Kondo",
                "bio" =>
                    "Легендарный композитор Nintendo, автор тем Super Mario Bros. и The Legend of Zelda.",
            ],
            [
                "name" => "Nobuo Uematsu",
                "bio" =>
                    "Один из самых известных композиторов видеоигр, автор классических саундтреков Final Fantasy.",
            ],
            [
                "name" => 'Martin O\'Donnell',
                "bio" =>
                    "Создатель эпического саундтрека к оригинальной трилогии Halo и Destiny.",
            ],
            [
                "name" => "Yoko Shimomura",
                "bio" =>
                    "Автор музыки к Kingdom Hearts, Final Fantasy XV и Street Fighter II.",
            ],
            [
                "name" => "Keiichi Okabe",
                "bio" =>
                    "Основатель студии Monaca, композитор серий NieR Replicant и NieR:Automata.",
            ],
            [
                "name" => "Inon Zur",
                "bio" =>
                    "Автор эпических оркестровых тем Fallout 3, Fallout 4, Dragon Age: Origins и Starfield.",
            ],
            [
                "name" => "Kelly Bailey",
                "bio" =>
                    "Композитор и саунд-дизайнер золотой эпохи Valve: Half-Life, Half-Life 2 и Portal.",
            ],
            [
                "name" => "Jack Wall",
                "bio" =>
                    "Композитор космической оперы Mass Effect 1 & 2 и Call of Duty: Black Ops.",
            ],
        ];
        // 3. Создаем авторов, альбомы и треки
        foreach ($composers as $compData) {
            $author = Author::firstOrCreate(
                ["name" => $compData["name"]],
                ["bio" => $compData["bio"]],
            );
            // Создаем по 1-2 альбома для каждого автора
            for ($a = 1; $a <= 2; $a++) {
                $album = Album::firstOrCreate(
                    [
                        "author_id" => $author->id,
                        "title" => "{$author->name} - Original Soundtrack Vol. {$a}",
                    ],
                    [
                        "status_id" => $publishedStatus->id,
                        "release_date" => now()
                            ->subYears(rand(1, 10))
                            ->subMonths(rand(1, 12))
                            ->toDateString(),
                        "description" => "Официальный саундтрек. Композитор: {$author->name}.",
                        "position" => $a,
                    ],
                );
                // Создаем по 3-4 трека в каждом альбоме
                for ($t = 1; $t <= 4; $t++) {
                    Track::firstOrCreate(
                        [
                            "album_id" => $album->id,
                            "title" => "Track {$t}: Theme of {$author->name} Part {$t}",
                        ],
                        [
                            "author_id" => $author->id,
                            "status_id" => $publishedStatus->id,
                            "duration_ms" => rand(120, 360) * 1000, // От 2 до 6 минут
                            "file_size" => rand(4000000, 15000000), // ~4-15 МБ
                            "mime_type" => "audio/mpeg",
                            "storage_key" => null, // Фиктивный ключ без реального mp3 файла
                        ],
                    );
                }
            }
        }
    }
}
