<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\On;

class CartCounter extends Component
{
    public int $totalItems = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('cart-updated')]
    public function updateCount()
    {
        $cart = session()->get('cart', []);
        $this->totalItems = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['quantity'] ?? 1);
        }, 0);
    }

    public function render()
    {
        return view('livewire.public.cart-counter');
    }
}
