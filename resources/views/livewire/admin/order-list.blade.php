<div class="space-y-6">
    
    <!-- Top Filter Header -->
    <div class="bg-[#FFFDF8] p-6 rounded-3xl border border-[#EADDC9] shadow-sm space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-black text-[#C21818] uppercase tracking-widest">Control Operativo</span>
                    @if($isManager)
                        <span class="bg-[#17A085]/10 text-[#17A085] border border-[#17A085]/30 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase">
                            📍 {{ Auth::user()->branch->name ?? 'Sucursal' }}
                        </span>
                    @endif
                </div>
                <h1 class="font-bebas text-3xl sm:text-4xl text-[#1F1F1F] mt-1 tracking-wide uppercase">Historial & Pedidos en Vivo</h1>
                <p class="text-xs text-[#6B6255]">Gestiona las órdenes recibidas vía web y canal oficial de WhatsApp.</p>
            </div>

            <!-- Search input -->
            <div class="relative min-w-[260px]">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="🔍 Buscar # orden, cliente, tel..." 
                    class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-2xl px-4 py-2.5 text-xs text-[#1F1F1F] placeholder-gray-400 focus:outline-none focus:border-[#C21818]"
                >
            </div>
        </div>

        <!-- Filters Row -->
        <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-[#EADDC9]">
            <!-- Status Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar">
                @php
                    $statuses = [
                        'all' => 'Todos',
                        'pending' => '⏳ Pendientes',
                        'confirmed' => '👍 Confirmados',
                        'preparing' => '👨‍🍳 Preparando',
                        'completed' => '✅ Completados',
                        'cancelled' => '❌ Cancelados',
                    ];
                @endphp

                @foreach($statuses as $stKey => $stLabel)
                    <button 
                        wire:click="$set('selectedStatus', '{{ $stKey }}')"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all border cursor-pointer {{ $selectedStatus === $stKey ? 'bg-[#C21818] text-white border-[#C21818] shadow-sm' : 'bg-[#FDF8EE] text-[#524B40] border-[#EADDC9] hover:bg-[#FAF3E0]' }}"
                    >
                        {{ $stLabel }}
                    </button>
                @endforeach
            </div>

            @if(!$isManager)
                <!-- Superadmin Branch Filter -->
                <div class="flex items-center gap-2">
                    <span class="text-[11px] text-[#6B6255] font-bold">Sucursal:</span>
                    <select wire:model.live="selectedBranch" class="bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-1.5 text-xs text-[#1F1F1F] focus:outline-none focus:border-[#C21818]">
                        <option value="all">🌎 Todas las 7 Sucursales</option>
                        @foreach($branches as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
    </div>

    <!-- Orders Cards List -->
    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="diner-card rounded-3xl p-5 sm:p-6 space-y-4">
                
                <!-- Order Top Info -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#EADDC9] pb-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">🍔</span>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-base text-[#1F1F1F]">{{ $order->customer_name }}</h3>
                                <span class="font-mono text-xs font-black text-[#C21818] bg-[#C21818]/10 px-2 py-0.5 rounded-lg border border-[#C21818]/20">
                                    #{{ $order->order_number }}
                                </span>
                            </div>
                            <p class="text-xs text-[#6B6255] mt-0.5">
                                📍 <strong>{{ $order->branch->name ?? 'Mérida' }}</strong> • 📞 {{ $order->customer_phone }} • {{ $order->created_at->format('d/M/Y h:i A') }}
                            </p>
                        </div>
                    </div>

                    <!-- Status Changer & WhatsApp Direct Reply -->
                    <div class="flex items-center gap-2">
                        <!-- Direct Customer WhatsApp Button -->
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
                            $waMessage = urlencode("¡Hola {$order->customer_name}! 🍎 Te escribimos de Big Apple Diner sobre tu orden #{$order->order_number}.");
                            $waLink = "https://wa.me/52{$cleanPhone}?text={$waMessage}";
                        @endphp
                        <a 
                            href="{{ $waLink }}" 
                            target="_blank" 
                            class="bg-[#17A085]/10 hover:bg-[#17A085]/20 text-[#17A085] border border-[#17A085]/30 px-3 py-1.5 rounded-xl text-xs font-bold flex items-center gap-1.5 transition-colors shadow-sm"
                            title="Escribir al WhatsApp del Cliente"
                        >
                            <span>💬</span>
                            <span>Escribir al Cliente</span>
                        </a>

                        <select 
                            wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                            class="bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-1.5 text-xs font-bold text-[#1F1F1F] focus:outline-none focus:border-[#C21818]"
                        >
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Pendiente</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>👍 Confirmado</option>
                            <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>👨‍🍳 En Cocina</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✅ Completado</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelado</option>
                        </select>
                    </div>
                </div>

                <!-- Order Items Breakdown -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($order->items as $item)
                        <div class="bg-[#FDF8EE] p-3 rounded-2xl border border-[#EADDC9] space-y-1 text-xs">
                            <div class="flex justify-between items-start">
                                <span class="font-bold text-[#1F1F1F]">{{ $item->quantity }}x {{ $item->product_name }}</span>
                                <span class="font-price font-bold text-[#C21818]">${{ number_format($item->subtotal, 2) }}</span>
                            </div>
                            
                            @if(!empty($item->options_payload))
                                <div class="text-[10px] text-[#524B40] space-y-0.5">
                                    @foreach($item->options_payload as $k => $v)
                                        <div><strong class="text-[#17A085]">{{ $k }}:</strong> {{ $v }}</div>
                                    @endforeach
                                </div>
                            @endif

                            @if($item->notes)
                                <div class="text-[10px] text-[#E85D04] italic">
                                    "{{ $item->notes }}"
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Footer Summary & Delivery Type -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pt-3 border-t border-[#EADDC9] text-xs">
                    <div class="text-[#524B40] space-y-0.5">
                        <div>
                            Modalidad: <strong class="text-[#1F1F1F]">{{ $order->type === 'delivery' ? '🛵 Domicilio en Mérida' : '🏬 Recoger en Sucursal' }}</strong>
                        </div>
                        @if($order->delivery_address)
                            <div class="text-[#6B6255]">
                                📍 Dirección: {{ $order->delivery_address }}
                            </div>
                        @endif
                    </div>

                    <div class="text-right flex items-center gap-3">
                        <span class="text-[#6B6255] font-bold">Total:</span>
                        <span class="font-price font-extrabold text-xl text-[#C21818]">
                            ${{ number_format($order->total, 2) }}
                        </span>
                    </div>
                </div>

            </div>
        @empty
            <div class="text-center py-16 bg-[#FFFDF8] rounded-3xl border border-[#EADDC9]">
                <span class="text-4xl block mb-2">📋</span>
                <h3 class="text-base font-bold text-[#1F1F1F]">No se encontraron pedidos</h3>
                <p class="text-xs text-[#6B6255] mt-1">Los pedidos recibidos por la web o WhatsApp se listarán aquí en tiempo real.</p>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="pt-2">
            {{ $orders->links() }}
        </div>
    </div>

</div>
