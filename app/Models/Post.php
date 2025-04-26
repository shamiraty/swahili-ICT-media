<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    protected $dates = ['uploadedDate'];
    protected $fillable = [
        'category_id',
        'uploadedDate',
        'headingTitle',
        'image',
        'description',
        'targetAudience',
        'comment',
        'Author',
        'References',
        'uploaded_by',
        'thumbnail',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}