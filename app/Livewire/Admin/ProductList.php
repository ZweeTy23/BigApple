<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public string $search = '';
    public string $selectedCategory = 'all';

    // Quick price editing
    public ?int $editingProductId = null;
    public float $editingPrice = 0.00;

    public function toggleAvailability(int $productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $product->is_available = !$product->is_available;
            $product->save();
        }
    }

    public function startEditPrice(int $productId, float $price)
    {
        $this->editingProductId = $productId;
        $this->editingPrice = $price;
    }

    public function savePrice()
    {
        if ($this->editingProductId) {
            $product = Product::find($this->editingProductId);
            if ($product) {
                $product->price = $this->editingPrice;
                $product->save();
            }
            $this->editingProductId = null;
        }
    }

    public function cancelEditPrice()
    {
        $this->editingProductId = null;
    }

    public function render()
    {
        $categories = Category::all();

        $query = Product::with('category');

        if ($this->selectedCategory !== 'all') {
            $query->where('category_id', $this->selectedCategory);
        }

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $products = $query->orderBy('category_id')->get();

        return view('livewire.admin.product-list', [
            'categories' => $categories,
            'products' => $products,
        ])->layout('layouts.admin');
    }
}
