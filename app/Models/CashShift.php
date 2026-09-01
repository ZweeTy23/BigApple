<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashShift extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'user_id',
        'opened_at',
        'closed_at',
        'opening_amount',
        'cash_sales',
        'card_sales',
        'transfer_sales',
        'cash_expenses',
        'expected_cash',
        'counted_cash',
        'difference',
        'status',
        'notes',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'opening_amount' => 'float',
        'cash_sales' => 'float',
        'card_sales' => 'float',
        'transfer_sales' => 'float',
        'cash_expenses' => 'float',
        'expected_cash' => 'float',
        'counted_cash' => 'float',
        'difference' => 'float',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalSalesAttribute(): float
    {
        return $this->cash_sales + $this->card_sales + $this->transfer_sales;
    }
}
