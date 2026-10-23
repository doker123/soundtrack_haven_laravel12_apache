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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('album_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('status_id')->constrained();
            $table->string('title');
            $table->string('storage_key')->unique()->nullable(); // путь файла в Storage
            $table->string('mime_type', 128)->nullable();
            $table->unsignedBigInteger('file_size')->nullable(); // ← string из схемы, теперь байты
            $table->unsignedInteger('duration_ms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
