<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Ban extends Model
{
    protected $fillable = [
            'user_id',
            'banned_by_id',
            'reason',
            'expires_at',
    ];
    
    protected $casts = [
        'expires_at'=> 'datetime',
        
    ];

    public function user(): BelongsTo          // кого забанили
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function bannedBy(): BelongsTo      // кто забанил
    {
        return $this->belongsTo(User::class, 'banned_by_id');
    }

    public function isActive(): bool 
    {
        return $this->expires_at === null || $this->epires_at->isFuture();
    }
    
}
