<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title', 'short_description', 'published_at', 'author', 'image_path', 'link',
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    /**
     * @return array
     */
    public static function getAllowedFillable(): array
    {
        return [
            'id',
            ...(new self)->fillable,
            'created_at',
            'updated_at'
        ];
    }
}
