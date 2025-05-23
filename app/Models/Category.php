<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date'];

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}