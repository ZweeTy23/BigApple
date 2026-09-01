<div class="space-y-6">
    
    <!-- Title & Controls -->
    <div class="bg-[#FFFDF8] p-6 rounded-3xl border border-[#EADDC9] shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-bebas text-3xl sm:text-4xl text-[#1F1F1F] tracking-wide uppercase">Administrador de Menú & Precios</h1>
            <p class="text-xs text-[#6B6255]">Edita precios y controla la disponibilidad en tiempo real.</p>
        </div>

        <div class="flex items-center gap-3">
            <select wire:model.live="selectedCategory" class="bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-xs text-[#1F1F1F] focus:outline-none focus:border-[#C21818]">
                <option value="all">Todas las Categorías</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="🔍 Buscar platillo..." 
                class="bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-xs text-[#1F1F1F] placeholder-gray-400 focus:outline-none focus:border-[#C21818]"
            >
        </div>
    </div>

    <!-- Table -->
    <div class="bg-[#FFFDF8] rounded-3xl border border-[#EADDC9] overflow-hidden shadow-sm">
        <table class="w-full text-left text-xs text-[#1F1F1F]">
            <thead class="bg-[#FAF3E0] text-[#6B6255] uppercase text-[10px] tracking-wider border-b border-[#EADDC9]">
                <tr>
                    <th class="p-4">Producto</th>
                    <th class="p-4">Categoría</th>
                    <th class="p-4">Precio</th>
                    <th class="p-4 text-center">Disponibilidad</th>
                    <th class="p-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#EADDC9]">
                @foreach($products as $p)
                    <tr class="hover:bg-[#FDF8EE] transition-colors">
                        <td class="p-4">
                            <strong class="text-[#1F1F1F] text-sm block">{{ $p->name }}</strong>
                            <span class="text-[11px] text-[#6B6255] max-w-md block line-clamp-1">{{ $p->description }}</span>
                        </td>
                        <td class="p-4">
                            <span class="bg-[#FDF8EE] border border-[#EADDC9] px-2 py-1 rounded text-[10px] font-bold text-[#C21818]">
                                {{ $p->category->name }}
                            </span>
                        </td>
                        <td class="p-4 font-price font-extrabold text-sm text-[#C21818]">
                            @if($editingProductId === $p->id)
                                <div class="flex items-center gap-1">
                                    <input 
                                        type="number" 
                                        step="0.5" 
                                        wire:model="editingPrice" 
                                        class="w-20 bg-white border border-[#C21818] rounded px-2 py-1 text-xs text-[#1F1F1F]"
                                    >
                                    <button wire:click="savePrice" class="diner-button-primary px-2 py-1 rounded font-bold text-[10px] cursor-pointer">
                                        ✓
                                    </button>
                                    <button wire:click="cancelEditPrice" class="bg-gray-200 text-black px-2 py-1 rounded font-bold text-[10px] cursor-pointer">
                                        ✕
                                    </button>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <span>${{ number_format($p->price, 2) }}</span>
                                    <button 
                                        wire:click="editPrice({{ $p->id }})" 
                                        class="text-gray-400 hover:text-[#C21818] text-xs" 
                                        title="Editar precio"
                                    >
                                        ✏️
                                    </button>
                                </div>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <button 
                                wire:click="toggleAvailability({{ $p->id }})" 
                                class="px-3 py-1 rounded-full text-[11px] font-bold transition-all cursor-pointer {{ $p->is_available ? 'bg-emerald-100 text-[#17A085] border border-emerald-300' : 'bg-red-100 text-[#C21818] border border-red-300' }}"
                            >
                                {{ $p->is_available ? '✓ En Stock' : '✕ Agotado' }}
                            </button>
                        </td>
                        <td class="p-4 text-right">
                            <button 
                                wire:click="toggleAvailability({{ $p->id }})"
                                class="text-xs text-[#6B6255] hover:text-[#C21818] font-bold cursor-pointer"
                            >
                                Cambiar Estado
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pt-2">
        {{ $products->links() }}
    </div>

</div>
