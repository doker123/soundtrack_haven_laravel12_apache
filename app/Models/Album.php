<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    protected $fillable = [
        'author_i',
        'status_i',
        'titl',
        'cover_pat',
        'release_dat',
        'descriptio',
        'positio',
    ];

    protected $casts = [
        'release_date' => 'date',
        'position'     => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
    
    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }
    
}
