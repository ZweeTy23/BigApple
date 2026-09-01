<?php

namespace App\Livewire\Public;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class MenuComponent extends Component
{
    public string $activeCategorySlug = 'todos';
    public string $searchQuery = '';
    public ?string $toastMessage = null;

    protected $listeners = ['show-toast' => 'triggerToast'];

    public function triggerToast(string $message)
    {
        $this->toastMessage = $message;
        $this->dispatch('hide-toast-after-delay');
    }

    public function selectCategory(string $slug)
    {
        $this->activeCategorySlug = $slug;
    }

    public function render()
    {
        $categories = Category::withCount(['products' => function($q) {
            $q->where('is_available', true);
        }])->where('is_active', true)->orderBy('sort_order')->get();

        $productsQuery = Product::with('category')->where('is_available', true);

        if ($this->activeCategorySlug !== 'todos') {
            $category = Category::where('slug', $this->activeCategorySlug)->first();
            if ($category) {
                $productsQuery->where('category_id', $category->id);
            }
        }

        if (!empty($this->searchQuery)) {
            $productsQuery->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $this->searchQuery . '%');
            });
        }

        $products = $productsQuery->get();

        // Highlight Combos for Hero Fast-Food Section
        $featuredCombos = Product::whereIn('slug', ['big-pack', 'central-pack', 'paquete-pareja', 'paquete-familiar'])->get();

        $branches = \App\Models\Branch::where('is_active', true)->get();

        return view('livewire.public.menu-component', [
            'categories' => $categories,
            'products' => $products,
            'featuredCombos' => $featuredCombos,
            'branches' => $branches,
        ])->layout('layouts.app');
    }
}
