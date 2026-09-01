<div>
    @if($isOpen && $product)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-[#FFFDF8] border border-[#EADDC9] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                
                <!-- Header / Close button -->
                <div class="bg-gradient-to-r from-[#C21818] via-[#D11919] to-[#8E0E15] px-6 py-4 flex items-center justify-between text-white shadow-md">
                    <div>
                        <span class="text-[10px] font-bold uppercase bg-black/20 px-2 py-0.5 rounded text-[#F5A623]">
                            {{ $product->category->name }}
                        </span>
                        <h3 class="font-bebas text-2xl tracking-wide mt-1" id="modal-title">
                            {{ $product->name }}
                        </h3>
                    </div>
                    <button wire:click="closeModal" class="text-white hover:text-[#F5A623] text-xl font-bold bg-black/20 hover:bg-black/40 w-8 h-8 rounded-full flex items-center justify-center cursor-pointer">
                        ✕
                    </button>
                </div>

                <!-- Product Image Banner in Modal -->
                <div class="relative h-48 sm:h-56 w-full {{ $product->image ? 'bg-gradient-to-br from-[#FFFDF8] via-[#FAF3E0] to-[#F5E6CC] flex items-center justify-center p-4' : 'bg-black/20' }} overflow-hidden border-b border-[#EADDC9]">
                    <img 
                        src="{{ $product->image_url }}" 
                        alt="{{ $product->name }}" 
                        class="w-full h-full {{ $product->image ? 'object-contain drop-shadow-xl' : 'object-cover' }}"
                    >
                    @if($product->badge)
                        <div class="absolute top-3 left-3">
                            <span class="text-[10px] font-black uppercase tracking-wider text-white bg-[#C21818] px-2.5 py-1 rounded-full shadow-md">
                                {{ $product->badge }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                    <!-- Description -->
                    <p class="text-xs text-[#524B40] leading-relaxed bg-[#FDF8EE] p-3.5 rounded-2xl border border-[#EADDC9]">
                        {{ $product->description }}
                    </p>

                    <!-- Burger Fries Swap Option -->
                    @if($product->type === 'burger')
                        <div class="space-y-3">
                            <label class="block text-xs font-black text-[#E85D04] uppercase tracking-wider">
                                🍟 Acompañamiento de Papas (Todas incluyen Papas Fritas Cajún):
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                                <button 
                                    type="button"
                                    wire:click="selectFries('Cajún (Incluidas)', 0)"
                                    class="p-3 rounded-2xl border text-left flex flex-col justify-between transition-all cursor-pointer {{ $selectedFries === 'Cajún (Incluidas)' ? 'border-[#E85D04] bg-[#E85D04]/10 text-[#1F1F1F] font-bold shadow-sm' : 'border-[#EADDC9] bg-[#FDF8EE] text-[#524B40] hover:bg-[#FAF3E0]' }}"
                                >
                                    <span>Papas Cajún</span>
                                    <span class="text-[10px] text-[#17A085] font-bold">Incluidas</span>
                                </button>
                                <button 
                                    type="button"
                                    wire:click="selectFries('Papas a la Francesa', 15)"
                                    class="p-3 rounded-2xl border text-left flex flex-col justify-between transition-all cursor-pointer {{ $selectedFries === 'Papas a la Francesa' ? 'border-[#E85D04] bg-[#E85D04]/10 text-[#1F1F1F] font-bold shadow-sm' : 'border-[#EADDC9] bg-[#FDF8EE] text-[#524B40] hover:bg-[#FAF3E0]' }}"
                                >
                                    <span>Papas Francesa</span>
                                    <span class="text-[10px] text-[#C21818] font-bold">+ $15.00</span>
                                </button>
                                <button 
                                    type="button"
                                    wire:click="selectFries('Papas Gajo', 15)"
                                    class="p-3 rounded-2xl border text-left flex flex-col justify-between transition-all cursor-pointer {{ $selectedFries === 'Papas Gajo' ? 'border-[#E85D04] bg-[#E85D04]/10 text-[#1F1F1F] font-bold shadow-sm' : 'border-[#EADDC9] bg-[#FDF8EE] text-[#524B40] hover:bg-[#FAF3E0]' }}"
                                >
                                    <span>Papas Gajo</span>
                                    <span class="text-[10px] text-[#C21818] font-bold">+ $15.00</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Chicken Sandwich Sauce Picker -->
                    @if($product->type === 'chicken_sandwich')
                        <div class="space-y-3">
                            <label class="block text-xs font-black text-[#C21818] uppercase tracking-wider">
                                🍗 Selecciona la Salsa para bañar tu Sandwich:
                            </label>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                @foreach(['Jack Daniel\'s', 'Buffalo', 'BBQ', 'Mango Habanero'] as $sauce)
                                    <button 
                                        type="button"
                                        wire:click="selectSauce('{{ $sauce }}')"
                                        class="p-3 rounded-2xl border text-center font-bold transition-all cursor-pointer {{ $selectedSauce === $sauce ? 'border-[#C21818] bg-[#C21818]/15 text-[#C21818] shadow-sm' : 'border-[#EADDC9] bg-[#FDF8EE] text-[#524B40] hover:bg-[#FAF3E0]' }}"
                                    >
                                        {{ $sauce }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Variants Portion Selectable -->
                    @if($product->type === 'portion_selectable' && !empty($product->variants))
                        <div class="space-y-3">
                            <label class="block text-xs font-black text-[#17A085] uppercase tracking-wider">
                                📦 Selecciona el tamaño u orden:
                            </label>
                            <div class="space-y-2">
                                @foreach($product->variants as $variant)
                                    <button 
                                        type="button"
                                        wire:click="selectVariant('{{ $variant['label'] }}', {{ $variant['price'] }})"
                                        class="w-full p-3.5 rounded-2xl border flex items-center justify-between transition-all text-xs font-bold cursor-pointer {{ $selectedVariantLabel === $variant['label'] ? 'border-[#17A085] bg-[#17A085]/10 text-[#1F1F1F]' : 'border-[#EADDC9] bg-[#FDF8EE] text-[#524B40] hover:bg-[#FAF3E0]' }}"
                                    >
                                        <span>{{ $variant['label'] }}</span>
                                        <span class="text-[#C21818] font-price font-extrabold text-sm">${{ number_format($variant['price'], 2) }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Custom Instructions Notes -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-[#1F1F1F]">
                            ✍️ Indicaciones especiales (ej. sin cebolla, aderezo a un lado):
                        </label>
                        <input 
                            type="text" 
                            wire:model="notes" 
                            placeholder="Ej. Sin pepinillos, extra servilletas..." 
                            class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-4 py-2.5 text-xs text-[#1F1F1F] placeholder-gray-400 focus:outline-none focus:border-[#C21818]"
                        >
                    </div>

                    <!-- Quantity & Price Summary -->
                    <div class="flex items-center justify-between pt-4 border-t border-[#EADDC9]">
                        <div class="flex items-center gap-3 bg-[#FDF8EE] p-1.5 rounded-2xl border border-[#EADDC9]">
                            <button wire:click="decrementQuantity" class="w-8 h-8 rounded-xl bg-white hover:bg-[#EADDC9] text-[#1F1F1F] font-bold text-lg flex items-center justify-center cursor-pointer">
                                -
                            </button>
                            <span class="font-bold text-[#1F1F1F] text-base px-2">{{ $quantity }}</span>
                            <button wire:click="incrementQuantity" class="w-8 h-8 rounded-xl bg-white hover:bg-[#EADDC9] text-[#1F1F1F] font-bold text-lg flex items-center justify-center cursor-pointer">
                                +
                            </button>
                        </div>

                        <div class="text-right">
                            <span class="text-[10px] text-[#6B6255] block uppercase font-bold">Subtotal</span>
                            <span class="text-2xl font-price font-extrabold text-[#C21818]">
                                ${{ number_format(($selectedPrice + $friesExtraPrice) * $quantity, 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="bg-[#FAF3E0] px-6 py-4 flex items-center justify-end gap-3 border-t border-[#EADDC9]">
                    <button 
                        wire:click="closeModal" 
                        class="px-4 py-2 rounded-xl text-xs font-bold text-[#6B6255] hover:text-black hover:bg-[#EADDC9]/50 transition-colors cursor-pointer"
                    >
                        Cancelar
                    </button>
                    <button 
                        wire:click="addToCart" 
                        class="diner-button-primary px-6 py-2.5 rounded-2xl text-xs font-black text-white shadow-md flex items-center gap-2 cursor-pointer uppercase tracking-wider"
                    >
                        <span>Agregar al Pedido</span>
                        <span>🛒</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
