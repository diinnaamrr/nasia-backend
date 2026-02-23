<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'title',
        'slug',
        'description',
        'base_price',
        'quantity',
        'thumbnail',
        'active'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function promoCampaigns()
    {
        return $this->belongsToMany(PromoCampaign::class)
            ->withPivot('discount_rate');
    }

    public function getFinalPriceAttribute()
    {
        $activePromo = $this->promoCampaigns()
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->first();

        if ($activePromo) {
            return $this->base_price -
                ($this->base_price *
                $activePromo->pivot->discount_rate / 100);
        }

        return $this->base_price;
    }
}

