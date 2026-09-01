<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name',
        'category',
        'unit',
        'current_stock',
        'min_stock',
        'unit_cost',
    ];

    protected $casts = [
        'current_stock' => 'float',
        'min_stock' => 'float',
        'unit_cost' => 'float',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->current_stock <= $this->min_stock;
    }
}
