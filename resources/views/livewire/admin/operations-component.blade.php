<div class="space-y-6">
    
    <!-- Header & Branch Selector Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-[#FFFDF8] p-6 rounded-3xl border border-[#EADDC9] shadow-sm">
        <div class="space-y-1">
            <div class="flex items-center gap-2.5">
                <span class="text-2xl">⚙️</span>
                <h1 class="font-bebas text-3xl text-[#1F1F1F] tracking-wide uppercase">
                    Operaciones & Control de Sucursales
                </h1>
            </div>
            <p class="text-xs text-[#6B6255]">
                Caja, reloj checador de asistencia, inventario de insumos, gastos y disponibilidad de menú.
            </p>
        </div>

        @if(auth()->user()->isSuperAdmin())
            <!-- Super Admin 7 Branches Switcher -->
            <div class="flex items-center gap-1.5 bg-[#FDF8EE] p-1.5 rounded-2xl border border-[#EADDC9] overflow-x-auto max-w-full">
                <span class="text-xs text-[#6B6255] font-bold px-2 whitespace-nowrap">Sucursal:</span>
                @foreach($branches as $b)
                    <button 
                        type="button" 
                        wire:click="$set('selectedBranch', '{{ $b->id }}')"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer whitespace-nowrap {{ $selectedBranch == $b->id ? 'bg-[#C21818] text-white shadow-sm' : 'text-[#524B40] hover:text-[#C21818]' }}"
                    >
                        {{ $b->zone ?? $b->name }}
                    </button>
                @endforeach
            </div>
        @else
            <!-- Locked Branch for Branch Manager -->
            <div class="flex items-center gap-2 bg-[#17A085]/10 border border-[#17A085]/30 px-3.5 py-1.5 rounded-2xl text-xs font-bold text-[#17A085]">
                <span>📍 {{ $activeBranch->name ?? 'Mi Sucursal' }}</span>
            </div>
        @endif
    </div>

    @if($flashMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-[#17A085] text-xs font-bold flex items-center justify-between shadow-sm">
            <span>{{ $flashMessage }}</span>
            <button wire:click="$set('flashMessage', '')" class="text-[#17A085] hover:text-black text-base cursor-pointer">✕</button>
        </div>
    @endif

    <!-- Operational Navigation Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 no-scrollbar border-b border-[#EADDC9]">
        <button 
            wire:click="$set('activeTab', 'caja')"
            class="px-5 py-3 rounded-2xl font-bold text-xs flex items-center gap-2 transition-all cursor-pointer whitespace-nowrap {{ $activeTab === 'caja' ? 'bg-[#C21818] text-white shadow-sm' : 'bg-[#FFFDF8] text-[#524B40] border border-[#EADDC9] hover:bg-[#FAF3E0]' }}"
        >
            <span class="text-base">💵</span>
            <span>Apertura y Cierre de Caja</span>
        </button>

        <button 
            wire:click="$set('activeTab', 'asistencia')"
            class="px-5 py-3 rounded-2xl font-bold text-xs flex items-center gap-2 transition-all cursor-pointer whitespace-nowrap {{ $activeTab === 'asistencia' ? 'bg-[#C21818] text-white shadow-sm' : 'bg-[#FFFDF8] text-[#524B40] border border-[#EADDC9] hover:bg-[#FAF3E0]' }}"
        >
            <span class="text-base">👥</span>
            <span>Empleados & Reloj Checador</span>
        </button>

        <button 
            wire:click="$set('activeTab', 'insumos')"
            class="px-5 py-3 rounded-2xl font-bold text-xs flex items-center gap-2 transition-all cursor-pointer whitespace-nowrap {{ $activeTab === 'insumos' ? 'bg-[#C21818] text-white shadow-sm' : 'bg-[#FFFDF8] text-[#524B40] border border-[#EADDC9] hover:bg-[#FAF3E0]' }}"
        >
            <span class="text-base">📦</span>
            <span>Insumos & Inventario</span>
        </button>

        <button 
            wire:click="$set('activeTab', 'gastos')"
            class="px-5 py-3 rounded-2xl font-bold text-xs flex items-center gap-2 transition-all cursor-pointer whitespace-nowrap {{ $activeTab === 'gastos' ? 'bg-[#C21818] text-white shadow-sm' : 'bg-[#FFFDF8] text-[#524B40] border border-[#EADDC9] hover:bg-[#FAF3E0]' }}"
        >
            <span class="text-base">💸</span>
            <span>Compras & Gastos</span>
        </button>

        <button 
            wire:click="$set('activeTab', 'menu')"
            class="px-5 py-3 rounded-2xl font-bold text-xs flex items-center gap-2 transition-all cursor-pointer whitespace-nowrap {{ $activeTab === 'menu' ? 'bg-[#C21818] text-white shadow-sm' : 'bg-[#FFFDF8] text-[#524B40] border border-[#EADDC9] hover:bg-[#FAF3E0]' }}"
        >
            <span class="text-base">🍔</span>
            <span>Bebidas & Menú de Sucursal</span>
        </button>
    </div>

    <!-- TAB 1: APERTURA Y CIERRE DE CAJA -->
    @if($activeTab === 'caja')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Current Shift Card -->
            <div class="lg:col-span-2 bg-[#FFFDF8] rounded-3xl p-6 border border-[#EADDC9] space-y-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-[#EADDC9] pb-4">
                    <div>
                        <h2 class="font-bebas text-2xl text-[#1F1F1F] tracking-wide">Estado de Caja Actual</h2>
                        <p class="text-xs text-[#6B6255]">Sucursal: <strong class="text-[#C21818]">{{ $activeBranch->name }}</strong></p>
                    </div>
                    @if($currentShift)
                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-[#17A085] border border-emerald-300 text-xs font-bold animate-pulse">
                            ● Caja Abierta
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-red-100 text-[#C21818] border border-red-300 text-xs font-bold">
                            ○ Caja Cerrada
                        </span>
                    @endif
                </div>

                @if($currentShift)
                    <!-- Open Shift Breakdown -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="bg-[#FDF8EE] p-4 rounded-2xl border border-[#EADDC9] space-y-1">
                            <span class="text-[10px] text-[#6B6255] uppercase tracking-wider font-bold">Fondo Inicial</span>
                            <div class="font-price font-extrabold text-lg text-[#1F1F1F]">${{ number_format($currentShift->opening_amount, 2) }}</div>
                        </div>
                        <div class="bg-[#FDF8EE] p-4 rounded-2xl border border-[#EADDC9] space-y-1">
                            <span class="text-[10px] text-[#17A085] uppercase tracking-wider font-bold">Ventas Efectivo</span>
                            <div class="font-price font-extrabold text-lg text-[#17A085]">+${{ number_format($currentShift->cash_sales, 2) }}</div>
                        </div>
                        <div class="bg-[#FDF8EE] p-4 rounded-2xl border border-[#EADDC9] space-y-1">
                            <span class="text-[10px] text-[#C21818] uppercase tracking-wider font-bold">Salidas Efectivo</span>
                            <div class="font-price font-extrabold text-lg text-[#C21818]">-${{ number_format($currentShift->cash_expenses, 2) }}</div>
                        </div>
                        <div class="bg-[#FDF8EE] p-4 rounded-2xl border border-[#EADDC9] space-y-1">
                            <span class="text-[10px] text-[#F5A623] uppercase tracking-wider font-bold">Efectivo Esperado</span>
                            <div class="font-price font-extrabold text-lg text-[#F5A623]">
                                ${{ number_format($currentShift->opening_amount + $currentShift->cash_sales - $currentShift->cash_expenses, 2) }}
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#FDF8EE] p-4 rounded-2xl border border-[#EADDC9] flex flex-wrap gap-4 text-xs text-[#524B40]">
                        <div>💳 <strong>Ventas con Tarjeta:</strong> ${{ number_format($currentShift->card_sales, 2) }}</div>
                        <div>📲 <strong>Ventas por Transferencia:</strong> ${{ number_format($currentShift->transfer_sales, 2) }}</div>
                        <div>🕒 <strong>Hora de Apertura:</strong> {{ $currentShift->opened_at->format('h:i A') }}</div>
                    </div>

                    <!-- Close Cash Drawer Form -->
                    <div class="bg-[#FAF3E0] p-5 rounded-2xl border border-[#EADDC9] space-y-4">
                        <h3 class="font-bold text-sm text-[#1F1F1F] flex items-center gap-2">
                            <span>🔒</span>
                            <span>Corte y Cierre de Turno</span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-[#1F1F1F]">Efectivo Contado en Caja ($):</label>
                                <input 
                                    type="number" 
                                    step="0.50" 
                                    wire:model="countedCash" 
                                    placeholder="Ej. 4570.00"
                                    class="w-full bg-white border border-[#EADDC9] rounded-xl px-3 py-2 text-sm text-[#1F1F1F] font-mono focus:border-[#C21818] focus:outline-none"
                                >
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-[#1F1F1F]">Notas de Cierre / Observaciones:</label>
                                <input 
                                    type="text" 
                                    wire:model="shiftNotes" 
                                    placeholder="Sin faltantes / Turno completo"
                                    class="w-full bg-white border border-[#EADDC9] rounded-xl px-3 py-2 text-sm text-[#1F1F1F] focus:border-[#C21818] focus:outline-none"
                                >
                            </div>
                        </div>

                        <button 
                            type="button" 
                            wire:click="closeCashDrawer({{ $currentShift->id }})"
                            class="w-full py-3 rounded-xl diner-button-primary text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md cursor-pointer"
                        >
                            Confirmar y Cerrar Caja de Turno
                        </button>
                    </div>
                @else
                    <!-- Open Drawer Trigger -->
                    <div class="py-8 text-center space-y-4">
                        <div class="w-16 h-16 bg-[#FDF8EE] rounded-full flex items-center justify-center mx-auto text-3xl border border-[#EADDC9]">💵</div>
                        <div class="space-y-1">
                            <h3 class="font-bold text-base text-[#1F1F1F]">No hay turno de caja abierto en esta sucursal</h3>
                            <p class="text-xs text-[#6B6255]">Ingresa el fondo inicial para abrir la caja del día.</p>
                        </div>

                        <div class="max-w-xs mx-auto space-y-3">
                            <div class="space-y-1 text-left">
                                <label class="text-[11px] font-bold text-[#1F1F1F]">Fondo Inicial en Efectivo ($):</label>
                                <input 
                                    type="number" 
                                    step="50" 
                                    wire:model="openingAmount"
                                    class="w-full bg-white border border-[#EADDC9] rounded-xl px-3 py-2 text-sm text-[#1F1F1F] font-mono text-center focus:border-[#C21818] focus:outline-none"
                                >
                            </div>

                            <button 
                                type="button" 
                                wire:click="openCashDrawer"
                                class="w-full py-3 rounded-xl diner-button-gold text-xs uppercase tracking-wider cursor-pointer shadow-md"
                            >
                                Iniciar Turno y Abrir Caja
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Past Shift History -->
            <div class="bg-[#FFFDF8] rounded-3xl p-6 border border-[#EADDC9] space-y-4 shadow-sm">
                <h2 class="font-bebas text-xl text-[#1F1F1F] tracking-wide">Historial de Cortes</h2>
                <div class="space-y-3 max-h-[450px] overflow-y-auto pr-1">
                    @forelse($pastShifts as $shift)
                        <div class="p-3.5 rounded-2xl bg-[#FDF8EE] border border-[#EADDC9] text-xs space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-[#1F1F1F]">{{ $shift->opened_at->format('d/M/Y') }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $shift->status === 'open' ? 'bg-emerald-100 text-[#17A085]' : 'bg-gray-100 text-[#6B6255]' }}">
                                    {{ $shift->status === 'open' ? 'Abierta' : 'Cerrada' }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-1 text-[11px] text-[#6B6255]">
                                <div>Ventas Total: <strong class="text-[#1F1F1F]">${{ number_format($shift->total_sales, 2) }}</strong></div>
                                <div>Diferencia: <strong class="{{ $shift->difference < 0 ? 'text-[#C21818]' : 'text-[#17A085]' }}">${{ number_format($shift->difference, 2) }}</strong></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-[#6B6255] text-center py-4">No hay historial previo.</p>
                    @endforelse
                </div>
            </div>

        </div>
    @endif

    <!-- TAB 2: EMPLEADOS & ASISTENCIA -->
    @if($activeTab === 'asistencia')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Employee Attendance Live List -->
            <div class="lg:col-span-2 bg-[#FFFDF8] rounded-3xl p-6 border border-[#EADDC9] space-y-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-[#EADDC9] pb-4">
                    <div>
                        <h2 class="font-bebas text-2xl text-[#1F1F1F] tracking-wide">Reloj Checador Digital</h2>
                        <p class="text-xs text-[#6B6255]">Asistencia del personal de hoy: <strong>{{ now()->format('d/M/Y') }}</strong></p>
                    </div>
                    <span class="text-xs bg-[#FDF8EE] px-3 py-1 rounded-xl text-[#524B40] border border-[#EADDC9] font-bold">
                        {{ $employees->count() }} Empleados Registrados
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($employees as $emp)
                        @php
                            $todayRec = $emp->today_attendance;
                        @endphp
                        <div class="p-4 rounded-2xl bg-[#FDF8EE] border border-[#EADDC9] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-sm text-[#1F1F1F]">{{ $emp->name }}</h4>
                                    <span class="text-[10px] bg-[#C21818]/10 text-[#C21818] border border-[#C21818]/20 px-2 py-0.5 rounded font-bold">{{ $emp->position }}</span>
                                </div>
                                <div class="text-xs text-[#6B6255]">
                                    📞 {{ $emp->phone ?? 'Sin teléfono' }} | Salario: ${{ number_format($emp->salary_monthly, 2) }}/mes
                                </div>
                            </div>

                            <!-- Clock In / Out Buttons -->
                            <div class="flex items-center gap-2">
                                @if(!$todayRec)
                                    <button 
                                        type="button" 
                                        wire:click="clockIn({{ $emp->id }})"
                                        class="px-4 py-2 rounded-xl diner-button-aqua text-white font-bold text-xs flex items-center gap-1.5 transition-all shadow-sm cursor-pointer"
                                    >
                                        <span>⏰</span>
                                        <span>Registrar Entrada</span>
                                    </button>
                                @elseif($todayRec && !$todayRec->clock_out)
                                    <div class="text-right">
                                        <div class="text-[11px] text-[#17A085] font-bold">Entró: {{ $todayRec->clock_in }}</div>
                                        <button 
                                            type="button" 
                                            wire:click="clockOut({{ $emp->id }})"
                                            class="mt-1 px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold text-xs transition-all cursor-pointer"
                                        >
                                            Registrar Salida 👋
                                        </button>
                                    </div>
                                @else
                                    <div class="text-right text-xs">
                                        <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 font-bold text-[10px]">
                                            Turno Completado ({{ $todayRec->clock_in }} - {{ $todayRec->clock_out }})
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-[#6B6255] text-xs">
                            No hay empleados dados de alta en esta sucursal.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Create New Employee Form -->
            <div class="bg-[#FFFDF8] rounded-3xl p-6 border border-[#EADDC9] space-y-4 shadow-sm">
                <h2 class="font-bebas text-xl text-[#1F1F1F] tracking-wide">Alta de Empleado</h2>
                
                <form wire:submit.prevent="createEmployee" class="space-y-3.5 text-xs">
                    <div class="space-y-1">
                        <label class="font-bold text-[#1F1F1F]">Nombre Completo:*</label>
                        <input 
                            type="text" 
                            wire:model="employeeName" 
                            placeholder="Ej. Luis Ramírez" 
                            class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] focus:border-[#C21818] focus:outline-none"
                            required
                        >
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-[#1F1F1F]">Puesto / Cargo:*</label>
                        <select 
                            wire:model="employeePosition" 
                            class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] focus:border-[#C21818] focus:outline-none"
                        >
                            <option value="Cocinero Principal">Cocinero Principal</option>
                            <option value="Chef de Parrilla & Smash">Chef de Parrilla & Smash</option>
                            <option value="Cajero">Cajero</option>
                            <option value="Repartidor Express">Repartidor Express</option>
                            <option value="Mesero / Ayudante General">Mesero / Ayudante General</option>
                            <option value="Gerente de Turno">Gerente de Turno</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-[#1F1F1F]">Teléfono Móvil:</label>
                        <input 
                            type="text" 
                            wire:model="employeePhone" 
                            placeholder="9991234567" 
                            class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] focus:border-[#C21818] focus:outline-none"
                        >
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-[#1F1F1F]">Sueldo Mensual ($):</label>
                        <input 
                            type="number" 
                            wire:model="employeeSalary" 
                            class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] font-mono focus:border-[#C21818] focus:outline-none"
                        >
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3 rounded-xl diner-button-primary text-white font-bold text-xs uppercase tracking-wider cursor-pointer shadow-md"
                    >
                        Guardar Empleado
                    </button>
                </form>
            </div>

        </div>
    @endif

    <!-- TAB 3: INSUMOS E INVENTARIO -->
    @if($activeTab === 'insumos')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Supplies Inventory Table -->
            <div class="lg:col-span-2 bg-[#FFFDF8] rounded-3xl p-6 border border-[#EADDC9] space-y-4 shadow-sm">
                <div class="flex items-center justify-between border-b border-[#EADDC9] pb-4">
                    <div>
                        <h2 class="font-bebas text-2xl text-[#1F1F1F] tracking-wide">Inventario de Materias Primas</h2>
                        <p class="text-xs text-[#6B6255]">Control de insumos en {{ $activeBranch->name }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-[#1F1F1F]">
                        <thead class="bg-[#FAF3E0] text-[10px] text-[#6B6255] uppercase tracking-wider">
                            <tr>
                                <th class="p-3">Insumo</th>
                                <th class="p-3">Categoría</th>
                                <th class="p-3">Stock Actual</th>
                                <th class="p-3">Mínimo</th>
                                <th class="p-3 text-right">Ajuste Rápido</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EADDC9]">
                            @forelse($supplies as $sup)
                                <tr class="hover:bg-[#FDF8EE] transition-colors">
                                    <td class="p-3">
                                        <div class="font-bold text-[#1F1F1F]">{{ $sup->name }}</div>
                                        <div class="text-[10px] text-[#6B6255] font-mono">${{ number_format($sup->unit_cost, 2) }} / {{ $sup->unit }}</div>
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 py-0.5 rounded bg-[#FDF8EE] text-[10px] text-[#524B40] border border-[#EADDC9]">{{ $sup->category }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono font-extrabold text-sm {{ $sup->is_low_stock ? 'text-[#C21818]' : 'text-[#17A085]' }}">
                                                {{ $sup->current_stock }} {{ $sup->unit }}
                                            </span>
                                            @if($sup->is_low_stock)
                                                <span class="text-[9px] bg-red-100 text-[#C21818] px-1.5 py-0.5 rounded font-bold animate-pulse">¡Bajo!</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-3 text-[#6B6255] font-mono">
                                        {{ $sup->min_stock }} {{ $sup->unit }}
                                    </td>
                                    <td class="p-3 text-right">
                                        <div class="inline-flex items-center gap-1 bg-white p-1 rounded-lg border border-[#EADDC9]">
                                            <button wire:click="adjustStock({{ $sup->id }}, -1)" class="w-6 h-6 rounded bg-[#FDF8EE] hover:bg-[#EADDC9] text-[#1F1F1F] font-bold cursor-pointer">-1</button>
                                            <button wire:click="adjustStock({{ $sup->id }}, 1)" class="w-6 h-6 rounded bg-[#FDF8EE] hover:bg-[#EADDC9] text-[#1F1F1F] font-bold cursor-pointer">+1</button>
                                            <button wire:click="adjustStock({{ $sup->id }}, 5)" class="w-6 h-6 rounded bg-[#F5A623]/20 hover:bg-[#F5A623]/30 text-[#1F1F1F] font-bold cursor-pointer">+5</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-[#6B6255]">No hay insumos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- New Supply Form -->
            <div class="bg-[#FFFDF8] rounded-3xl p-6 border border-[#EADDC9] space-y-4 shadow-sm">
                <h2 class="font-bebas text-xl text-[#1F1F1F] tracking-wide">Nuevo Insumo</h2>

                <form wire:submit.prevent="createSupply" class="space-y-3.5 text-xs">
                    <div class="space-y-1">
                        <label class="font-bold text-[#1F1F1F]">Nombre del Insumo:*</label>
                        <input 
                            type="text" 
                            wire:model="supplyName" 
                            placeholder="Ej. Tocino Ahumado" 
                            class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] focus:border-[#C21818] focus:outline-none"
                            required
                        >
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-[#1F1F1F]">Categoría:*</label>
                        <select wire:model="supplyCategory" class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] focus:border-[#C21818] focus:outline-none">
                            <option value="Carnes & Pollo">Carnes & Pollo</option>
                            <option value="Panadería">Panadería</option>
                            <option value="Quesos & Lácteos">Quesos & Lácteos</option>
                            <option value="Salsas & Aderezos">Salsas & Aderezos</option>
                            <option value="Bebidas & Jarabes">Bebidas & Jarabes</option>
                            <option value="Abarrotes & Papas">Abarrotes & Papas</option>
                            <option value="Empaques & Desechables">Empaques & Desechables</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="font-bold text-[#1F1F1F]">Unidad:*</label>
                            <input type="text" wire:model="supplyUnit" placeholder="kg / pzas / litros" class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] focus:border-[#C21818] focus:outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-[#1F1F1F]">Stock Inicial:*</label>
                            <input type="number" step="0.5" wire:model="supplyStock" class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] font-mono focus:border-[#C21818] focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="font-bold text-[#1F1F1F]">Stock Mínimo Alerta:</label>
                            <input type="number" step="0.5" wire:model="supplyMinStock" class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] font-mono focus:border-[#C21818] focus:outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-[#1F1F1F]">Costo Unitario ($):</label>
                            <input type="number" step="0.5" wire:model="supplyUnitCost" class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] font-mono focus:border-[#C21818] focus:outline-none">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl diner-button-gold text-xs uppercase tracking-wider cursor-pointer shadow-md">
                        Agregar al Inventario
                    </button>
                </form>
            </div>

        </div>
    @endif

    <!-- TAB 4: COMPRAS Y GASTOS -->
    @if($activeTab === 'gastos')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Expense History List -->
            <div class="lg:col-span-2 bg-[#FFFDF8] rounded-3xl p-6 border border-[#EADDC9] space-y-4 shadow-sm">
                <div class="flex items-center justify-between border-b border-[#EADDC9] pb-4">
                    <div>
                        <h2 class="font-bebas text-2xl text-[#1F1F1F] tracking-wide">Registro de Compras & Gastos</h2>
                        <p class="text-xs text-[#6B6255]">Egresos operativos de {{ $activeBranch->name }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-[#6B6255] uppercase">Total Gastos Registrados:</span>
                        <div class="font-price font-extrabold text-xl text-[#C21818]">
                            ${{ number_format($expenses->sum('amount'), 2) }}
                        </div>
                    </div>
                </div>

                <div class="space-y-3 max-h-[500px] overflow-y-auto pr-1">
                    @forelse($expenses as $exp)
                        <div class="p-4 rounded-2xl bg-[#FDF8EE] border border-[#EADDC9] flex items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-[#1F1F1F]">{{ $exp->description }}</span>
                                    <span class="px-2 py-0.5 rounded bg-white text-[10px] text-[#524B40] border border-[#EADDC9]">{{ $exp->category }}</span>
                                </div>
                                <div class="text-[11px] text-[#6B6255] flex items-center gap-3">
                                    <span>📅 {{ $exp->date->format('d/M/Y') }}</span>
                                    <span>💳 Método: <strong>{{ ucfirst($exp->payment_method) }}</strong></span>
                                    @if($exp->receipt_number)
                                        <span>🧾 Folio: {{ $exp->receipt_number }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="font-price font-extrabold text-lg text-[#C21818] whitespace-nowrap">
                                -${{ number_format($exp->amount, 2) }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-[#6B6255] text-xs">
                            No hay compras ni gastos registrados en esta sucursal.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- New Expense Form -->
            <div class="bg-[#FFFDF8] rounded-3xl p-6 border border-[#EADDC9] space-y-4 shadow-sm">
                <h2 class="font-bebas text-xl text-[#1F1F1F] tracking-wide">Registrar Compra / Gasto</h2>

                <form wire:submit.prevent="recordExpense" class="space-y-3.5 text-xs">
                    <div class="space-y-1">
                        <label class="font-bold text-[#1F1F1F]">Descripción del Gasto:*</label>
                        <input 
                            type="text" 
                            wire:model="expenseDescription" 
                            placeholder="Ej. Compra de 5 bolsas de hielo" 
                            class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] focus:border-[#C21818] focus:outline-none"
                            required
                        >
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-[#1F1F1F]">Categoría:*</label>
                        <select wire:model="expenseCategory" class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] focus:border-[#C21818] focus:outline-none">
                            <option value="Insumos / Perecederos">Insumos / Perecederos (Verduras, Hielo, etc.)</option>
                            <option value="Servicios">Servicios (Gas LP, Luz, Agua, Internet)</option>
                            <option value="Mantenimiento">Mantenimiento de Cocina / Local</option>
                            <option value="Nómina / Propinas">Nómina / Propinas / Extras</option>
                            <option value="Empaques & Desechables">Empaques & Desechables</option>
                            <option value="Otros">Otros Gastos Menores</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="font-bold text-[#1F1F1F]">Monto ($):*</label>
                            <input type="number" step="0.5" wire:model="expenseAmount" placeholder="0.00" class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] font-mono focus:border-[#C21818] focus:outline-none" required>
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-[#1F1F1F]">Método de Pago:</label>
                            <select wire:model="expensePaymentMethod" class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] focus:border-[#C21818] focus:outline-none">
                                <option value="cash">Efectivo de Caja</option>
                                <option value="transfer">Transferencia Bancaria</option>
                                <option value="card">Tarjeta Corporativa</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-[#1F1F1F]">Número de Ticket o Factura:</label>
                        <input type="text" wire:model="expenseReceipt" placeholder="Ej. FAC-10293" class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl px-3 py-2 text-[#1F1F1F] focus:border-[#C21818] focus:outline-none">
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl diner-button-primary text-white font-bold text-xs uppercase tracking-wider cursor-pointer shadow-md">
                        Registrar Egreso
                    </button>
                </form>
            </div>

        </div>
    @endif

    <!-- TAB 5: BEBIDAS & MENÚ DISPONIBLE -->
    @if($activeTab === 'menu')
        <div class="bg-[#FFFDF8] rounded-3xl p-6 border border-[#EADDC9] space-y-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-[#EADDC9] pb-4">
                <div>
                    <h2 class="font-bebas text-2xl text-[#1F1F1F] tracking-wide">Disponibilidad de Platillos y Bebidas</h2>
                    <p class="text-xs text-[#6B6255]">Marca productos como "Agotado" si se terminaron los ingredientes en esta sucursal.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($products as $prod)
                    <div class="p-4 rounded-2xl bg-[#FDF8EE] border border-[#EADDC9] flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" class="w-12 h-12 rounded-xl object-cover border border-[#EADDC9]">
                            <div>
                                <h4 class="font-bold text-xs text-[#1F1F1F]">{{ $prod->name }}</h4>
                                <div class="text-[10px] text-[#C21818] font-mono font-bold">${{ number_format($prod->price, 2) }}</div>
                                <span class="text-[9px] text-[#6B6255]">{{ $prod->category->name }}</span>
                            </div>
                        </div>

                        <button 
                            type="button" 
                            wire:click="toggleProductStatus({{ $prod->id }})"
                            class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all cursor-pointer {{ $prod->is_available ? 'bg-emerald-100 text-[#17A085] border border-emerald-300 hover:bg-emerald-200' : 'bg-red-100 text-[#C21818] border border-red-300 hover:bg-red-200' }}"
                        >
                            {{ $prod->is_available ? '✓ Disponible' : '✕ Agotado' }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
