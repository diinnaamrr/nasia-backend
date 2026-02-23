<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'headline',
        'starts_at',
        'ends_at',
        'enabled'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'enabled' => 'boolean',
    ];

    public function stockUnits()
    {
        return $this->belongsToMany(StockUnit::class)
            ->withPivot('discount_rate');
    }
}

