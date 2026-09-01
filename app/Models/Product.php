<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'badge',
        'type',
        'is_available',
        'variants',
    ];

    protected $casts = [
        'price' => 'float',
        'is_available' => 'boolean',
        'variants' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image)) {
            return $this->image;
        }

        // Curated high quality food photography fallbacks based on category/type
        $categorySlug = $this->category->slug ?? '';

        return match ($categorySlug) {
            'entradas-snacks' => 'https://images.unsplash.com/photo-1576107232684-1279f3908594?auto=format&fit=crop&w=600&q=80', // Wings/Fries
            'hamburguesas' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=600&q=80', // Burger
            'chicken-sandwich' => 'https://images.unsplash.com/photo-1625813506062-0aeb1d7a094b?auto=format&fit=crop&w=600&q=80', // Crispy chicken
            'smash-burgers' => 'https://images.unsplash.com/photo-1586190848861-99aa4a171e90?auto=format&fit=crop&w=600&q=80', // Smash burger
            'fettuccines-pasta' => 'https://images.unsplash.com/photo-1621996346565-e3d5d6281691?auto=format&fit=crop&w=600&q=80', // Fettuccine pasta
            'paquetes-combos' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=600&q=80', // Mega combo platter
            'crepas' => 'https://images.unsplash.com/photo-1519676867240-f03562e64548?auto=format&fit=crop&w=600&q=80', // Crepes
            'bebidas-postres' => 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?auto=format&fit=crop&w=600&q=80', // Frappe/drink
            default => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=600&q=80',
        };
    }
}
