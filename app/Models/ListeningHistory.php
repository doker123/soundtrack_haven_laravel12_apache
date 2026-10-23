<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class ListeningHistory extends Model
{
    protected $fillable = [
        'user_id',
        'track_id',
        'played_duration_ms',
        'played_at',
    ];

    protected $casts = [
        'played_duration_ms' => 'integer',
        'played_at'          => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    public function listenedPercent(): int
    {
        $durationMs = $this->track?->duration_ms;
    
        if (! $durationMs || ! $this->played_duration_ms) {
            return 0;
        }
    
        return min(100, (int) round($this->played_duration_ms / $durationMs * 100));
    }

    public function scopeOfUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
    
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderByDesc('played_at');
    }

}
