<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Track extends Model
{
    protected $fillable = [
        'author_id',
        'album_id',
        'status_id',
        'title',
        'storage_key',
        'mime_type',
        'file_size',
        'duration_ms',
    ];
    protected $casts = [
        'file_size'   => 'integer',
        'duration_ms' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
    
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
    
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
