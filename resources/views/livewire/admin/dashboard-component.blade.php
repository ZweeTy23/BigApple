<div class="space-y-6">
    
    <!-- Top Greeting & Branch Selector -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-[#FFFDF8] p-6 rounded-3xl border border-[#EADDC9] shadow-sm">
        <div class="space-y-1">
            <div class="flex items-center gap-3">
                <span class="text-3xl">📊</span>
                <div>
                    <h1 class="font-bebas text-3xl sm:text-4xl text-[#1F1F1F] tracking-wide uppercase">
                        Panel de Control {{ $isManager ? 'de Sucursal' : 'General' }}
                    </h1>
                    <p class="text-xs text-[#6B6255]">
                        @if($isManager)
                            Operaciones exclusivas de: <strong class="text-[#C21818]">{{ $activeBranchModel->name }}</strong>
                        @else
                            Control consolidado de las 7 sucursales Big Apple en Mérida
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @if(!$isManager)
            <!-- Super Admin Branch Switcher Pills (7 Branches) -->
            <div class="flex items-center gap-1.5 bg-[#FDF8EE] p-1.5 rounded-2xl border border-[#EADDC9] overflow-x-auto max-w-full">
                <button 
                    type="button" 
                    wire:click="selectBranch('all')"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap {{ $selectedBranch === 'all' ? 'bg-[#C21818] text-white shadow-sm' : 'text-[#524B40] hover:text-[#C21818]' }}"
                >
                    🌎 7 Sucursales
                </button>
                @foreach($branches as $b)
                    <button 
                        type="button" 
                        wire:click="selectBranch('{{ $b->id }}')"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap {{ $selectedBranch == $b->id ? 'bg-[#C21818] text-white shadow-sm' : 'text-[#524B40] hover:text-[#C21818]' }}"
                    >
                        {{ $b->zone ?? $b->name }}
                    </button>
                @endforeach
            </div>
        @else
            <!-- Manager Badge -->
            <div class="inline-flex items-center gap-2 bg-[#17A085]/10 border border-[#17A085]/30 px-4 py-2 rounded-2xl text-xs font-bold text-[#17A085]">
                <span>📍</span>
                <span>{{ $activeBranchModel->name }}</span>
            </div>
        @endif
    </div>

    <!-- Financial KPIs & P&L (Ventas, Gastos, Utilidad Neta) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Sales -->
        <div class="bg-[#FFFDF8] p-5 rounded-3xl border border-[#EADDC9] space-y-3 shadow-sm hover:border-[#17A085] transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-[#6B6255] uppercase tracking-wider">Ventas Brutas</span>
                <span class="w-9 h-9 rounded-2xl bg-emerald-50 text-[#17A085] flex items-center justify-center text-lg border border-emerald-200">💰</span>
            </div>
            <div>
                <div class="font-price font-extrabold text-2xl sm:text-3xl text-[#17A085]">
                    ${{ number_format($totalSales, 2) }}
                </div>
                <div class="text-[11px] text-[#6B6255] mt-1">
                    {{ $totalOrders }} pedidos en el sistema
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="bg-[#FFFDF8] p-5 rounded-3xl border border-[#EADDC9] space-y-3 shadow-sm hover:border-[#C21818] transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-[#6B6255] uppercase tracking-wider">Gastos & Compras</span>
                <span class="w-9 h-9 rounded-2xl bg-red-50 text-[#C21818] flex items-center justify-center text-lg border border-red-200">💸</span>
            </div>
            <div>
                <div class="font-price font-extrabold text-2xl sm:text-3xl text-[#C21818]">
                    -${{ number_format($totalExpenses, 2) }}
                </div>
                <div class="text-[11px] text-[#6B6255] mt-1">
                    Insumos, gas, luz y nómina
                </div>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="bg-[#FFFDF8] p-5 rounded-3xl border border-[#EADDC9] space-y-3 shadow-sm hover:border-[#F5A623] transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-[#6B6255] uppercase tracking-wider">Utilidad Neta (P&L)</span>
                <span class="w-9 h-9 rounded-2xl bg-amber-50 text-[#F5A623] flex items-center justify-center text-lg border border-amber-200">📈</span>
            </div>
            <div>
                <div class="font-price font-extrabold text-2xl sm:text-3xl {{ $netProfit >= 0 ? 'text-[#F5A623]' : 'text-[#C21818]' }}">
                    ${{ number_format($netProfit, 2) }}
                </div>
                <div class="text-[11px] text-[#6B6255] mt-1">
                    Margen real después de egresos
                </div>
            </div>
        </div>

        <!-- Operations Health -->
        <div class="bg-[#FFFDF8] p-5 rounded-3xl border border-[#EADDC9] space-y-3 shadow-sm hover:border-[#17A085] transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-[#6B6255] uppercase tracking-wider">Operación en Vivo</span>
                <span class="w-9 h-9 rounded-2xl bg-teal-50 text-[#17A085] flex items-center justify-center text-lg border border-teal-200">⚙️</span>
            </div>
            <div class="space-y-1 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-[#6B6255]">Estado de Caja:</span>
                    <span class="font-bold {{ $openShift ? 'text-[#17A085]' : 'text-[#C21818]' }}">
                        {{ $openShift ? '● Abierta' : '○ Cerrada' }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[#6B6255]">Insumos en Alerta:</span>
                    <span class="font-bold {{ $lowStockCount > 0 ? 'text-[#E85D04]' : 'text-[#524B40]' }}">
                        {{ $lowStockCount }} items
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[#6B6255]">Personal Activo:</span>
                    <span class="font-bold text-[#1F1F1F]">{{ $totalEmployees }} empleados</span>
                </div>
            </div>
        </div>

    </div>

    @if(!$isManager && count($branchStats) > 0)
        <!-- Super Admin 7 Branches Comparative Performance -->
        <div class="bg-[#FFFDF8] p-6 rounded-3xl border border-[#EADDC9] space-y-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bebas text-2xl text-[#1F1F1F] tracking-wide uppercase">
                        Comparativa de Rendimiento (7 Sucursales)
                    </h2>
                    <p class="text-xs text-[#6B6255]">Ventas, gastos y margen de ganancia de cada punto de venta en Mérida</p>
                </div>
                <a href="{{ route('admin.operations') }}" class="text-xs text-[#C21818] hover:underline font-bold flex items-center gap-1">
                    <span>Gestionar Operaciones</span>
                    <span>→</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($branchStats as $bs)
                    <div class="bg-[#FDF8EE] p-4 rounded-2xl border border-[#EADDC9] space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span>📍</span>
                                <h3 class="font-bold text-xs text-[#1F1F1F] truncate max-w-[150px]">{{ $bs['name'] }}</h3>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold {{ $bs['has_open_shift'] ? 'bg-emerald-100 text-[#17A085]' : 'bg-gray-200 text-gray-600' }}">
                                {{ $bs['has_open_shift'] ? 'Abierta' : 'Cerrada' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-3 gap-1.5 text-center">
                            <div class="bg-white p-2 rounded-xl border border-[#EADDC9]">
                                <span class="text-[9px] text-[#6B6255] uppercase font-bold block">Ventas</span>
                                <div class="font-price font-bold text-xs text-[#17A085]">${{ number_format($bs['sales'], 2) }}</div>
                            </div>
                            <div class="bg-white p-2 rounded-xl border border-[#EADDC9]">
                                <span class="text-[9px] text-[#6B6255] uppercase font-bold block">Gastos</span>
                                <div class="font-price font-bold text-xs text-[#C21818]">${{ number_format($bs['expenses'], 2) }}</div>
                            </div>
                            <div class="bg-white p-2 rounded-xl border border-[#EADDC9]">
                                <span class="text-[9px] text-[#6B6255] uppercase font-bold block">Utilidad</span>
                                <div class="font-price font-bold text-xs {{ $bs['net'] >= 0 ? 'text-[#F5A623]' : 'text-[#C21818]' }}">
                                    ${{ number_format($bs['net'], 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Orders & Recent Expenses Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Orders -->
        <div class="bg-[#FFFDF8] p-6 rounded-3xl border border-[#EADDC9] space-y-4 shadow-sm">
            <div class="flex items-center justify-between border-b border-[#EADDC9] pb-3">
                <h2 class="font-bebas text-xl text-[#1F1F1F] tracking-wide">Últimos Pedidos</h2>
                <a href="{{ route('admin.orders') }}" class="text-xs text-[#C21818] hover:underline font-bold">Ver todos →</a>
            </div>

            <div class="space-y-2.5">
                @forelse($recentOrders as $order)
                    <div class="p-3 rounded-2xl bg-[#FDF8EE] border border-[#EADDC9] flex items-center justify-between gap-3 text-xs">
                        <div class="space-y-0.5">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-[#1F1F1F]">{{ $order->customer_name }}</span>
                                <span class="text-[10px] font-mono text-[#C21818]">#{{ $order->order_number }}</span>
                            </div>
                            <div class="text-[11px] text-[#6B6255]">
                                📍 {{ $order->branch->name ?? 'Mérida' }} | {{ $order->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="font-price font-bold text-sm text-[#1F1F1F]">${{ number_format($order->total, 2) }}</div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $order->status === 'completed' ? 'bg-emerald-100 text-[#17A085]' : 'bg-amber-100 text-[#F5A623]' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-[#6B6255] text-center py-6">No hay pedidos registrados.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Expenses -->
        <div class="bg-[#FFFDF8] p-6 rounded-3xl border border-[#EADDC9] space-y-4 shadow-sm">
            <div class="flex items-center justify-between border-b border-[#EADDC9] pb-3">
                <h2 class="font-bebas text-xl text-[#1F1F1F] tracking-wide">Últimos Gastos Registrados</h2>
                <a href="{{ route('admin.operations') }}" class="text-xs text-[#C21818] hover:underline font-bold">Ver caja & gastos →</a>
            </div>

            <div class="space-y-2.5">
                @forelse($recentExpenses as $exp)
                    <div class="p-3 rounded-2xl bg-[#FDF8EE] border border-[#EADDC9] flex items-center justify-between gap-3 text-xs">
                        <div class="space-y-0.5">
                            <div class="font-bold text-[#1F1F1F]">{{ $exp->description }}</div>
                            <div class="text-[11px] text-[#6B6255]">
                                🏷️ {{ $exp->category }} | {{ $exp->branch->name ?? 'Sucursal' }}
                            </div>
                        </div>

                        <div class="font-price font-bold text-sm text-[#C21818] whitespace-nowrap">
                            -${{ number_format($exp->amount, 2) }}
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-[#6B6255] text-center py-6">No hay gastos recientes.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
