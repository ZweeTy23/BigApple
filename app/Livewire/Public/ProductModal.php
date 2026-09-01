<?php

namespace App\Livewire\Public;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class ProductModal extends Component
{
    public bool $isOpen = false;
    public ?Product $product = null;
    
    // Customization state
    public string $selectedVariantLabel = '';
    public float $selectedPrice = 0.00;
    public string $selectedFries = 'Cajún (Incluidas)';
    public float $friesExtraPrice = 0.00;
    public string $selectedSauce = 'Jack Daniel\'s';
    public string $notes = '';
    public int $quantity = 1;

    #[On('open-product-modal')]
    public function openModal(int $productId)
    {
        $this->product = Product::with('category')->find($productId);
        
        if (!$this->product) {
            return;
        }

        $this->quantity = 1;
        $this->notes = '';
        $this->selectedFries = 'Cajún (Incluidas)';
        $this->friesExtraPrice = 0.00;
        $this->selectedSauce = 'Jack Daniel\'s';
        
        if ($this->product->type === 'portion_selectable' && !empty($this->product->variants)) {
            $this->selectedVariantLabel = $this->product->variants[0]['label'] ?? '';
            $this->selectedPrice = (float)($this->product->variants[0]['price'] ?? $this->product->price);
        } else {
            $this->selectedVariantLabel = '';
            $this->selectedPrice = (float)$this->product->price;
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->product = null;
    }

    public function selectVariant(string $label, float $price)
    {
        $this->selectedVariantLabel = $label;
        $this->selectedPrice = $price;
    }

    public function selectFries(string $fries, float $extraPrice)
    {
        $this->selectedFries = $fries;
        $this->friesExtraPrice = $extraPrice;
    }

    public function selectSauce(string $sauce)
    {
        $this->selectedSauce = $sauce;
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        if (!$this->product) return;

        $options = [];

        if ($this->product->type === 'burger') {
            $options['Papas'] = $this->selectedFries;
        }

        if ($this->product->type === 'chicken_sandwich') {
            $options['Salsa'] = $this->selectedSauce;
        }

        if ($this->selectedVariantLabel) {
            $options['Porción/Tamaño'] = $this->selectedVariantLabel;
        }

        $unitPrice = $this->selectedPrice + $this->friesExtraPrice;
        
        $cart = session()->get('cart', []);
        
        $cartItemKey = md5($this->product->id . json_encode($options) . $this->notes);

        if (isset($cart[$cartItemKey])) {
            $cart[$cartItemKey]['quantity'] += $this->quantity;
        } else {
            $cart[$cartItemKey] = [
                'key' => $cartItemKey,
                'product_id' => $this->product->id,
                'name' => $this->product->name,
                'unit_price' => $unitPrice,
                'quantity' => $this->quantity,
                'options' => $options,
                'notes' => $this->notes,
                'image' => $this->product->image,
            ];
        }

        session()->put('cart', $cart);

        $this->dispatch('cart-updated');
        $this->dispatch('open-cart');
        $this->dispatch('show-toast', message: '¡Agregado a tu pedido!');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.public.product-modal');
    }
}
