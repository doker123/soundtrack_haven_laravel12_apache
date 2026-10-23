<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avatars', function (Blueprint $table) {
            $table->id();
            $table->string('original_name');
            $table->string('extension', 16);           // png, jpg, webp...
            $table->unsignedBigInteger('file_size');   // размер в байтах
            $table->string('disk')->default('public'); // диск Storage
            $table->string('path');                    // путь к файлу на диске
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('avatar_id')
                ->nullable()      // не у всех пользователей есть аватар
                ->after('role_id')
                ->constrained()
                ->nullOnDelete(); // удаление аватара не трогает пользователя
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('avatar_id');
        });

        Schema::dropIfExists('avatars');
    }
};
