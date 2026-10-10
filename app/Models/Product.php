<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'category_id',
    'name',
    'slug',
    'description',
    'price',
    'stock',
    'image',
    'status',
])]
class Product extends Model
{
    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
