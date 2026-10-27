<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Album extends Model
{
    protected $fillable = [
        'author_id',
        'status_id',
        'title',
        'cover_path',
        'release_date',
        'description',
        'position',
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
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereHas('status', fn ($q) => $q->where('name', 'published'));
    }

}
