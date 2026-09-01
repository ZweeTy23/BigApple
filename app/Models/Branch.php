<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'zone',
        'category_type',
        'rating',
        'address',
        'city',
        'phone',
        'whatsapp_number',
        'schedule',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'float',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getCleanWhatsappNumberAttribute(): string
    {
        return preg_replace('/[^0-9]/', '', $this->whatsapp_number ?? '');
    }

    public function getWhatsappUrlAttribute(): string
    {
        $phone = $this->clean_whatsapp_number;
        $text = urlencode("¡Hola Big Apple Diner! 🗽 Me gustaría ordenar en la {$this->name}. ¿Tienen servicio disponible?");
        return "https://wa.me/{$phone}?text={$text}";
    }

    public function getGoogleMapsUrlAttribute(): string
    {
        return "https://www.google.com/maps/search/?api=1&query=" . urlencode("Big Apple Diner " . $this->address . " " . $this->city);
    }
}
