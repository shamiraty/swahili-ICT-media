<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;
    
    protected $casts = [
        'uploadedDate' => 'datetime:Y-m-d',
    ];
    protected $fillable = [
        'category_id',
        'uploadedDate',
        'headingTitle',
        'document',
        'targetAudience',
        'comment',
        'Author',
        'References',
        'uploaded_by',
        'thumbnail',
        'document_size',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}