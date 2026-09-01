<?php

namespace App\Livewire\Public;

use Livewire\Component;

class PastaBuilderWizard extends Component
{
    public int $currentStep = 1;

    // Wizard Selections
    public string $size = 'Individual';
    public float $basePrice = 149.00;
    public string $sauce = 'Alfredo';
    public string $protein = 'Pollo a la plancha';
    public array $selectedIngredients = ['Tocino', 'Champiñones', 'Queso Parmesano'];
    public string $notes = '';

    public array $availableSauces = ['Chipotle', 'Alfredo', 'Mantequilla'];
    public array $availableProteins = ['Tiras Crispy', 'Pollo a la plancha', 'Boneless', 'Champiñones'];
    public array $availableIngredients = [
        'Tocino',
        'Champiñones',
        'Jamón',
        'Pimiento',
        'Tomate',
        'Cebolla',
        'Queso Cheddar',
        'Queso Parmesano',
    ];

    public function selectSize(string $size, float $price)
    {
        $this->size = $size;
        $this->basePrice = $price;
    }

    public function selectSauce(string $sauce)
    {
        $this->sauce = $sauce;
    }

    public function selectProtein(string $protein)
    {
        $this->protein = $protein;
    }

    public function toggleIngredient(string $ingredient)
    {
        if (in_array($ingredient, $this->selectedIngredients)) {
            $this->selectedIngredients = array_values(array_diff($this->selectedIngredients, [$ingredient]));
        } else {
            if (count($this->selectedIngredients) < 3) {
                $this->selectedIngredients[] = $ingredient;
            } else {
                $this->dispatch('show-toast', message: 'Máximo 3 ingredientes permitidos.');
            }
        }
    }

    public function goToStep(int $step)
    {
        if ($step >= 1 && $step <= 4) {
            $this->currentStep = $step;
        }
    }

    public function nextStep()
    {
        if ($this->currentStep < 4) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function addPastaToCart()
    {
        if (count($this->selectedIngredients) === 0) {
            $this->dispatch('show-toast', message: 'Por favor elige al menos 1 ingrediente (hasta 3).');
            return;
        }

        $options = [
            'Tamaño' => $this->size,
            'Salsa' => $this->sauce,
            'Proteína' => $this->protein,
            '3 Ingredientes' => implode(', ', $this->selectedIngredients),
        ];

        $cart = session()->get('cart', []);
        $cartItemKey = md5('arma-tu-pasta-' . json_encode($options) . $this->notes);

        if (isset($cart[$cartItemKey])) {
            $cart[$cartItemKey]['quantity']++;
        } else {
            $cart[$cartItemKey] = [
                'key' => $cartItemKey,
                'product_id' => null,
                'name' => 'Arma tu Pasta (' . $this->size . ')',
                'unit_price' => $this->basePrice,
                'quantity' => 1,
                'options' => $options,
                'notes' => $this->notes,
                'image' => null,
            ];
        }

        session()->put('cart', $cart);

        $this->dispatch('cart-updated');
        $this->dispatch('open-cart');
        $this->dispatch('show-toast', message: '¡Tu Pasta personalizada fue agregada al carrito!');
        $this->currentStep = 1;
    }

    public function render()
    {
        return view('livewire.public.pasta-builder-wizard');
    }
}
