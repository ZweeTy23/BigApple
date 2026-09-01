<?php

namespace App\Livewire\Public;

use App\Models\Branch;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use Livewire\Attributes\On;

class CartComponent extends Component
{
    public bool $isOpen = false;
    public array $cart = [];
    
    // Order Form
    public string $orderType = 'delivery'; // 'delivery' or 'pickup'
    public ?int $selectedBranchId = null;
    public string $customerName = '';
    public string $customerPhone = '';
    public string $deliveryAddress = '';
    public string $orderNotes = '';
    public float $deliveryFee = 35.00;

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $branch = Branch::where('is_active', true)->first();
        if ($branch) {
            $this->selectedBranchId = $branch->id;
        }
    }

    #[On('toggle-cart')]
    public function toggleCart()
    {
        $this->isOpen = !$this->isOpen;
        $this->loadCart();
    }

    #[On('cart-updated')]
    public function loadCart()
    {
        $this->cart = session()->get('cart', []);
    }

    public function closeCart()
    {
        $this->isOpen = false;
    }

    public function updateQuantity(string $itemKey, int $change)
    {
        if (isset($this->cart[$itemKey])) {
            $this->cart[$itemKey]['quantity'] += $change;
            if ($this->cart[$itemKey]['quantity'] <= 0) {
                unset($this->cart[$itemKey]);
            }
            session()->put('cart', $this->cart);
            $this->dispatch('cart-updated');
        }
    }

    public function removeItem(string $itemKey)
    {
        if (isset($this->cart[$itemKey])) {
            unset($this->cart[$itemKey]);
            session()->put('cart', $this->cart);
            $this->dispatch('cart-updated');
        }
    }

    public function getSubtotalProperty(): float
    {
        return array_reduce($this->cart, function ($carry, $item) {
            return $carry + ($item['unit_price'] * $item['quantity']);
        }, 0.00);
    }

    public function getTotalProperty(): float
    {
        $subtotal = $this->subtotal;
        $fee = ($this->orderType === 'delivery') ? $this->deliveryFee : 0.00;
        return $subtotal + $fee;
    }

    public function checkoutWhatsApp()
    {
        $this->validate([
            'customerName' => 'required|min:3',
            'customerPhone' => 'required|min:8',
            'selectedBranchId' => 'required|exists:branches,id',
            'deliveryAddress' => $this->orderType === 'delivery' ? 'required|min:5' : 'nullable',
        ], [
            'customerName.required' => 'Por favor escribe tu nombre completo.',
            'customerPhone.required' => 'Escribe un teléfono de contacto.',
            'deliveryAddress.required' => 'Proporciona la dirección exacta para la entrega.',
        ]);

        if (empty($this->cart)) {
            $this->dispatch('show-toast', message: 'Tu carrito está vacío.');
            return;
        }

        $branch = Branch::find($this->selectedBranchId);
        $orderNumber = 'BAD-' . strtoupper(uniqid());

        // Save order to database
        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'order_type' => $this->orderType,
            'delivery_address' => $this->orderType === 'delivery' ? $this->deliveryAddress : null,
            'branch_id' => $this->selectedBranchId,
            'subtotal' => $this->subtotal,
            'delivery_fee' => ($this->orderType === 'delivery') ? $this->deliveryFee : 0.00,
            'total' => $this->total,
            'status' => 'pending',
            'notes' => $this->orderNotes,
        ]);

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'] ?? null,
                'product_name' => $item['name'],
                'unit_price' => $item['unit_price'],
                'quantity' => $item['quantity'],
                'selected_options' => $item['options'] ?? [],
                'total_price' => $item['unit_price'] * $item['quantity'],
            ]);
        }

        // Format clean WhatsApp message
        $message = "🍎 *PEDIDO WEB - BIG APPLE DINER* 🍎\n";
        $message .= "----------------------------------------\n";
        $message .= "📋 *Orden #:* {$orderNumber}\n";
        $message .= "👤 *Cliente:* {$this->customerName}\n";
        $message .= "📞 *Teléfono:* {$this->customerPhone}\n";
        $message .= "🏪 *Sucursal:* {$branch->name}\n";
        $message .= "🛵 *Tipo:* " . ($this->orderType === 'delivery' ? 'Envío a Domicilio' : 'Recoger en Sucursal') . "\n";
        
        if ($this->orderType === 'delivery') {
            $message .= "📍 *Dirección:* {$this->deliveryAddress}\n";
        }

        $message .= "----------------------------------------\n";
        $message .= "*DETALLE DEL PEDIDO:*\n\n";

        foreach ($this->cart as $item) {
            $itemTotal = number_format($item['unit_price'] * $item['quantity'], 2);
            $message .= "• *{$item['quantity']}x {$item['name']}* - \${$itemTotal}\n";
            
            if (!empty($item['options'])) {
                foreach ($item['options'] as $optName => $optVal) {
                    $message .= "   └ _{$optName}:_ {$optVal}\n";
                }
            }
            if (!empty($item['notes'])) {
                $message .= "   └ _Notas:_ {$item['notes']}\n";
            }
        }

        $message .= "\n----------------------------------------\n";
        $message .= "Subtotal: \$" . number_format($this->subtotal, 2) . "\n";
        if ($this->orderType === 'delivery') {
            $message .= "Envío a Domicilio: \$" . number_format($this->deliveryFee, 2) . "\n";
        }
        $message .= "*TOTAL A PAGAR:* \$" . number_format($this->total, 2) . "\n";
        $message .= "----------------------------------------\n";
        $message .= "¡Gracias por pedir en Big Apple Diner! 🗽";

        // Clean session cart
        session()->forget('cart');
        $this->cart = [];
        $this->dispatch('cart-updated');

        // Redirect to WhatsApp web/api
        $waPhone = preg_replace('/[^0-9]/', '', $branch->whatsapp_number);
        $waUrl = "https://wa.me/{$waPhone}?text=" . urlencode($message);

        $this->dispatch('open-whatsapp-link', url: $waUrl);
        $this->closeCart();
    }

    public function render()
    {
        return view('livewire.public.cart-component', [
            'branches' => Branch::where('is_active', true)->get(),
        ]);
    }
}
