<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = [
            'name',
            'avatar_id',
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
        
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Avatar::class);
    }

    public function sizeMb(): float
    {
        return round($this->file_size / 1024 ** 2, 2);
    }
}
