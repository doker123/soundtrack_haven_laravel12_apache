<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Avatar extends Model
{
    protected $fillable = [
        'original_name',
        'extension',
        'file_size',
        'disk',
        'path',
    ];
    protected $casts = [
        'file_size' => 'integer',
    ];

    public function users():HasMany
    {
        return $this->hasMany(User::class);
    }

    public function authors(): HasMany
    {
        return $this->hasMany(Author::class);
    }
    
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
