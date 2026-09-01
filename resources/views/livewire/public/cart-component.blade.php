<div 
    x-data="{ isOpen: @entangle('isOpen').live }" 
    x-on:open-cart.window="isOpen = true; $wire.loadCart()"
    x-on:toggle-cart.window="isOpen = !isOpen; $wire.loadCart()"
    x-on:open-whatsapp-link.window="window.open($event.detail.url, '_blank')"
    x-cloak
>
    <!-- Slide-over Drawer Backdrop -->
    <div 
        x-show="isOpen" 
        x-transition:enter="ease-in-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 transition-opacity" 
        @click="isOpen = false"
        wire:click="closeCart"
    ></div>

    <!-- Drawer Panel (Warm Cream Diner Theme) -->
    <div 
        x-show="isOpen"
        x-transition:enter="transform transition ease-in-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 z-50 max-w-full flex pl-10"
    >
        <div class="w-screen max-w-md bg-[#FFFDF8] border-l border-[#EADDC9] shadow-2xl flex flex-col justify-between">
            
            <!-- Header -->
            <div class="p-6 bg-gradient-to-r from-[#C21818] via-[#D11919] to-[#8E0E15] text-[#FFFDF8] flex items-center justify-between shadow-md">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🛍️</span>
                    <div>
                        <h2 class="font-bebas text-2xl tracking-wide">Tu Pedido Big Apple</h2>
                        <p class="text-xs text-[#F5A623]">Enviamos directo a la cocina por WhatsApp</p>
                    </div>
                </div>
                <button 
                    @click="isOpen = false"
                    wire:click="closeCart" 
                    class="text-white hover:text-[#F5A623] text-xl font-bold bg-black/20 hover:bg-black/40 w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                >
                    ✕
                </button>
            </div>

            <!-- Content Body -->
            <div class="flex-grow p-6 overflow-y-auto space-y-6">
                
                @if(empty($cart))
                    <div class="text-center py-16 space-y-4">
                        <div class="w-20 h-20 bg-[#FDF8EE] rounded-full flex items-center justify-center mx-auto text-4xl border border-[#EADDC9]">
                            🍔
                        </div>
                        <h3 class="text-lg font-bold text-[#1F1F1F]">Tu orden está vacía</h3>
                        <p class="text-xs text-[#6B6255] max-w-xs mx-auto">
                            Explora nuestro menú de hamburguesas con papas cajún, boneless, smash y pastas.
                        </p>
                    </div>
                @else
                    <!-- Cart Items List -->
                    <div class="space-y-3.5">
                        <h3 class="text-xs font-black text-[#C21818] uppercase tracking-wider">Productos en la Orden:</h3>
                        
                        @foreach($cart as $key => $item)
                            <div class="bg-[#FDF8EE] p-4 rounded-2xl border border-[#EADDC9] space-y-2">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="font-bold text-sm text-[#1F1F1F]">{{ $item['name'] }}</h4>
                                        <span class="text-[#C21818] font-price text-xs font-extrabold">${{ number_format($item['unit_price'], 2) }} c/u</span>
                                    </div>
                                    <button wire:click="removeItem('{{ $key }}')" class="text-gray-400 hover:text-[#C21818] text-xs font-bold cursor-pointer">
                                        Eliminar
                                    </button>
                                </div>

                                <!-- Selected Options -->
                                @if(!empty($item['options']))
                                    <div class="text-[11px] text-[#524B40] space-y-0.5 border-t border-[#EADDC9] pt-1.5 mt-1">
                                        @foreach($item['options'] as $optK => $optV)
                                            <div><strong class="text-[#17A085]">{{ $optK }}:</strong> {{ $optV }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                @if(!empty($item['notes']))
                                    <div class="text-[10px] text-[#E85D04] italic">
                                        "{{ $item['notes'] }}"
                                    </div>
                                @endif

                                <!-- Item Quantity Controls -->
                                <div class="flex items-center justify-between pt-2">
                                    <div class="flex items-center gap-2 bg-[#FFFDF8] px-2 py-1 rounded-xl border border-[#EADDC9]">
                                        <button wire:click="updateQuantity('{{ $key }}', -1)" class="w-6 h-6 rounded bg-[#FDF8EE] hover:bg-[#EADDC9] text-[#1F1F1F] font-bold text-sm flex items-center justify-center cursor-pointer">
                                            -
                                        </button>
                                        <span class="text-xs font-bold text-[#1F1F1F] px-1">{{ $item['quantity'] }}</span>
                                        <button wire:click="updateQuantity('{{ $key }}', 1)" class="w-6 h-6 rounded bg-[#FDF8EE] hover:bg-[#EADDC9] text-[#1F1F1F] font-bold text-sm flex items-center justify-center cursor-pointer">
                                            +
                                        </button>
                                    </div>
                                    <span class="font-price font-extrabold text-sm text-[#1F1F1F]">
                                        ${{ number_format($item['unit_price'] * $item['quantity'], 2) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Checkout Customer & Delivery Form -->
                    <div class="border-t border-[#EADDC9] pt-6 space-y-4">
                        <h3 class="text-xs font-black text-[#17A085] uppercase tracking-wider">Modalidad & Sucursal de Entrega</h3>

                        <!-- Delivery / Pickup Toggle -->
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <button 
                                type="button"
                                wire:click="$set('orderType', 'delivery')"
                                class="py-2.5 px-3 rounded-xl border text-center font-bold transition-all cursor-pointer {{ $orderType === 'delivery' ? 'bg-[#17A085] text-white border-[#17A085] shadow-sm' : 'bg-[#FDF8EE] text-[#524B40] border-[#EADDC9]' }}"
                            >
                                🛵 Domicilio en Mérida
                            </button>
                            <button 
                                type="button"
                                wire:click="$set('orderType', 'pickup')"
                                class="py-2.5 px-3 rounded-xl border text-center font-bold transition-all cursor-pointer {{ $orderType === 'pickup' ? 'bg-[#17A085] text-white border-[#17A085] shadow-sm' : 'bg-[#FDF8EE] text-[#524B40] border-[#EADDC9]' }}"
                            >
                                🏬 Recoger en Sucursal
                            </button>
                        </div>

                        <!-- Branch Selection (7 Branches) -->
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-[#1F1F1F]">Sucursal Big Apple:*</label>
                            <select 
                                wire:model="selectedBranchId" 
                                class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-xs text-[#1F1F1F] focus:outline-none focus:border-[#C21818]"
                            >
                                @foreach($branches as $b)
                                    <option value="{{ $b->id }}">
                                        {{ $b->name }} ({{ $b->zone ?? $b->address }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Customer Name -->
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-[#1F1F1F]">Tu Nombre Completo:*</label>
                            <input 
                                type="text" 
                                wire:model="customerName" 
                                placeholder="Ej. Mariana López" 
                                class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-xs text-[#1F1F1F] placeholder-gray-400 focus:outline-none focus:border-[#C21818]"
                            >
                            @error('customerName') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Customer Phone -->
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-[#1F1F1F]">Tu WhatsApp / Celular:*</label>
                            <input 
                                type="tel" 
                                wire:model="customerPhone" 
                                placeholder="Ej. 9991234567" 
                                class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-xs text-[#1F1F1F] placeholder-gray-400 focus:outline-none focus:border-[#C21818]"
                            >
                            @error('customerPhone') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Address if Delivery -->
                        @if($orderType === 'delivery')
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-[#1F1F1F]">Dirección de Entrega en Mérida:*</label>
                                <textarea 
                                    wire:model="deliveryAddress" 
                                    rows="2" 
                                    placeholder="Calle, número, cruzamientos, colonia, referencias..." 
                                    class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-xs text-[#1F1F1F] placeholder-gray-400 focus:outline-none focus:border-[#C21818]"
                                ></textarea>
                                @error('deliveryAddress') <span class="text-[10px] text-red-500">{{ $message }}</span> @enderror
                            </div>
                        @endif

                    </div>
                @endif
            </div>

            <!-- Footer Totals & WhatsApp Button -->
            @if(!empty($cart))
                <div class="p-6 bg-[#FAF3E0] border-t border-[#EADDC9] space-y-4">
                    <div class="space-y-1.5 text-xs text-[#524B40]">
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span class="font-price font-bold text-[#1F1F1F]">${{ number_format($this->subtotal, 2) }}</span>
                        </div>
                        @if($orderType === 'delivery')
                            <div class="flex justify-between">
                                <span>Costo de Envío Mérida:</span>
                                <span class="font-price font-bold text-[#E85D04]">+${{ number_format($this->deliveryFee, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-base font-extrabold text-[#1F1F1F] pt-2 border-t border-[#EADDC9]">
                            <span>TOTAL:</span>
                            <span class="font-price font-extrabold text-[#C21818] text-xl">${{ number_format($this->total, 2) }}</span>
                        </div>
                    </div>

                    <button 
                        wire:click="checkoutWhatsApp" 
                        class="w-full py-3.5 px-4 rounded-2xl font-black text-xs text-white diner-button-aqua transition-all shadow-xl flex items-center justify-center gap-2 uppercase tracking-wider cursor-pointer"
                    >
                        <span>Enviar Pedido por WhatsApp a Sucursal</span>
                        <span class="text-base">📲</span>
                    </button>
                </div>
            @endif

        </div>
    </div>
</div>
