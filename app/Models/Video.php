<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Video extends Model
{
    use HasFactory;
 

    protected $casts = [
        'uploadedDate' => 'datetime:Y-m-d',
    ];
    
    protected $fillable = [
        'category_id',
        'uploadedDate',
        'lengthHours',
        'headingTitle',
        'video',
        'targetAudience',
        'comment',
        'Author',
        'References',
        'uploaded_by',
        'thumbnail',
        'size',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class);
    }

    public function getUploadedDateVirtualAttribute()
    {
        return $this->uploadedDate?->diffForHumans();
    }
}