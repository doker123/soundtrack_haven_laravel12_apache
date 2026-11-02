<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = [
            'name',
            'image',
            'bio',
    ];

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }
    
    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }
        
    public function getImageUrlAttribute(): string
        {
            if ($this->image && Storage::disk('public')->exists($this->image)) {
                return Storage::disk('public')->url($this->image);
            }
            // Дефолтная картинка-заглушка (положите её в public/images/default-avatar.png)
            return asset('images/default-avatar.png');
        }

    public function sizeMb(): float
    {
        return round($this->file_size / 1024 ** 2, 2);
    }
}
