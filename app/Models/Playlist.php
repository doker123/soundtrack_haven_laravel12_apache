<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

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
        'is_public' => 'boolean',
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

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_path && Storage::disk('public')->exists($this->cover_path)) {
            return Storage::disk('public')->url($this->cover_path);
        }
        return asset('images/default-cover.png');
    }
}
