<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'cover_image',
        'visible',
        'display_order'
    ];

    public function stockUnits()
    {
        return $this->hasMany(StockUnit::class);
    }
}
