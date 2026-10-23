<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlaylistTrack extends Model
{
    protected $fillable = [
        'playlist_id',
        'track_id',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }
}