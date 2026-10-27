<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Playlist extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'cover_path',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',   // вот зачем был cast из прошлого урока
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Сырые строки сводной — для манипуляции позициями. */
    public function playlistTracks(): HasMany
    {
        return $this->hasMany(PlaylistTrack::class);
    }

    /** Упорядоченные треки плейлиста. */
    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'playlist_tracks')
            ->withPivot('position')
            ->orderByPivot('position');
    }
    
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }
}
