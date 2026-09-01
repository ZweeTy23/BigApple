<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name',
        'position',
        'phone',
        'salary_monthly',
        'is_active',
    ];

    protected $casts = [
        'salary_monthly' => 'float',
        'is_active' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function attendances()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function getTodayAttendanceAttribute()
    {
        return $this->attendances()->whereDate('date', now()->toDateString())->first();
    }
}
