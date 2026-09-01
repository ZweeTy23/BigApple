<div>
    <!-- Toast Notification -->
    <div 
        x-data="{ show: false, message: '' }"
        x-on:show-toast.window="message = $event.detail.message; show = true; setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed bottom-6 right-6 z-50 bg-[#17A085] text-white px-5 py-3.5 rounded-2xl shadow-2xl font-bold text-xs flex items-center gap-2 border border-white/20"
        style="display: none;"
    >
        <span class="text-base">🍔</span>
        <span x-text="message"></span>
    </div>

    <!-- FAST FOOD HERO & PROMOTIONS SECTION (WARM CREAM LIGHT MODE) -->
    <section id="promos" class="relative bg-gradient-to-b from-[#FFFDF8] via-[#FAF3E0] to-[#FDF8EE] pt-8 pb-16 overflow-hidden border-b border-[#EADDC9]">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-8">
            
            <!-- Delivery & Cajún Fries Banner -->
            <div class="bg-[#FFFDF8] p-5 rounded-3xl border border-[#EADDC9] shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#C21818] to-[#8E0E15] flex items-center justify-center text-2xl text-white shadow-md">
                        🍟
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-black text-[#E85D04] uppercase tracking-wider block">¡Especial Big Apple!</span>
                            <span class="bg-[#E85D04]/10 text-[#E85D04] text-[10px] font-bold px-2 py-0.5 rounded-full border border-[#E85D04]/20">Incluye Papas Cajún</span>
                        </div>
                        <p class="text-xs text-[#524B40] font-medium">Todas nuestras hamburguesas vienen acompañadas de papas fritas cajún sazonadas artesanalmente.</p>
                    </div>
                </div>

                <!-- 7 Branches Quick Navigation Pill -->
                <div class="flex items-center gap-2">
                    <a 
                        href="#sucursales" 
                        class="bg-[#FDF8EE] hover:bg-[#FAF3E0] text-[#1F1F1F] border border-[#EADDC9] px-4 py-2.5 rounded-2xl text-xs font-extrabold flex items-center gap-2 transition-all hover:border-[#C21818] shadow-sm"
                    >
                        <span>📍 7 Sucursales en Mérida</span>
                        <span class="text-[#17A085] font-mono">11 AM - 11:30 PM</span>
                    </a>
                </div>
            </div>

            <!-- Hero Stage -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center pt-2">
                
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 bg-[#C21818]/10 border border-[#C21818]/25 text-[#C21818] px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest">
                        <span>🔥</span> MULTICULTURAL TASTE • 7 SUCURSALES EN MÉRIDA
                    </div>

                    <h1 class="font-bebas text-5xl sm:text-7xl text-[#1F1F1F] leading-none tracking-wide uppercase">
                        EL AUTÉNTICO SABOR <br class="hidden sm:inline">
                        <span class="text-[#C21818]">
                            AMERICAN DINER
                        </span>
                        <span class="text-[#F5A623] block sm:inline"> EN MÉRIDA</span>
                    </h1>

                    <p class="text-xs sm:text-sm text-[#524B40] max-w-xl mx-auto lg:mx-0 font-medium leading-relaxed">
                        Hamburguesas artesanales con papas cajún, jugosos boneless bañados en salsa Jack Daniel's, pechugas crujientes de pollo estilo KFC, smash burgers a la plancha y pastas fettuccine al gusto.
                    </p>

                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="#menu" class="diner-button-primary px-8 py-4 rounded-2xl text-xs sm:text-sm uppercase tracking-wider shadow-xl flex items-center gap-2 cursor-pointer">
                            <span>Ver Menú & Ordenar</span>
                            <span>🍔</span>
                        </a>
                        <a href="#sucursales" class="diner-button-aqua px-7 py-4 rounded-2xl text-xs sm:text-sm uppercase tracking-wider shadow-xl flex items-center gap-2 cursor-pointer">
                            <span>WhatsApp por Sucursal</span>
                            <span>💬</span>
                        </a>
                    </div>

                    <!-- Quick Metrics Chips -->
                    <div class="grid grid-cols-3 gap-3 pt-4 max-w-md mx-auto lg:mx-0 text-center">
                        <div class="bg-[#FFFDF8] p-3.5 rounded-2xl border border-[#EADDC9] shadow-sm">
                            <span class="block font-price font-extrabold text-2xl text-[#C21818]">$85</span>
                            <span class="text-[10px] text-[#6B6255] uppercase font-bold">Burgers desde</span>
                        </div>
                        <div class="bg-[#FFFDF8] p-3.5 rounded-2xl border border-[#EADDC9] shadow-sm">
                            <span class="block font-price font-extrabold text-2xl text-[#17A085]">100%</span>
                            <span class="text-[10px] text-[#6B6255] uppercase font-bold">Carne & Pollo Fresco</span>
                        </div>
                        <div class="bg-[#FFFDF8] p-3.5 rounded-2xl border border-[#EADDC9] shadow-sm">
                            <span class="block font-price font-extrabold text-2xl text-[#F5A623]">7</span>
                            <span class="text-[10px] text-[#6B6255] uppercase font-bold">Sucursales Mérida</span>
                        </div>
                    </div>
                </div>

                <!-- Featured Pack Highlight Card (Sangría / Dark Red Accent) -->
                <div class="lg:col-span-5">
                    @if($featuredCombos->count() > 0)
                        @php $topCombo = $featuredCombos->first(); @endphp
                        <div class="bg-gradient-to-br from-[#8E0E15] to-[#C21818] text-[#FFFDF8] rounded-3xl border-2 border-[#F5A623] shadow-2xl overflow-hidden relative group">
                            
                            <!-- Top Image Banner for Combo -->
                            <div class="relative h-56 w-full overflow-hidden bg-black/40">
                                <img 
                                    src="{{ $topCombo->image_url }}" 
                                    alt="{{ $topCombo->name }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-[#8E0E15] via-transparent to-black/30"></div>
                                <div class="absolute top-4 right-4 bg-[#F5A623] text-[#1F1F1F] font-black text-[11px] px-3.5 py-1 rounded-full uppercase tracking-wider shadow-lg">
                                    ★ COMBO DESTACADO
                                </div>
                            </div>

                            <div class="p-6 space-y-4">
                                <div>
                                    <span class="text-[10px] font-bold text-[#F5A623] uppercase tracking-widest">Ideal para Compartir</span>
                                    <h3 class="font-bebas text-3xl text-white mt-1">{{ $topCombo->name }}</h3>
                                    <p class="text-xs text-[#FDF8EE]/90 mt-1 leading-relaxed line-clamp-3">
                                        {{ $topCombo->description }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-white/15">
                                    <div>
                                        <span class="text-[10px] text-white/70 uppercase block font-bold">Precio Combo</span>
                                        <span class="text-3xl font-price font-extrabold text-[#F5A623]">${{ number_format($topCombo->price, 2) }}</span>
                                    </div>
                                    <button 
                                        wire:click="$dispatch('open-product-modal', { productId: {{ $topCombo->id }} })"
                                        class="diner-button-gold px-6 py-3 rounded-2xl text-xs uppercase tracking-wider shadow-lg cursor-pointer"
                                    >
                                        Pedir Combo 🎁
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    <!-- MENU CATALOG SECTION (LIGHT CREAM MODE) -->
    <section id="menu" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Section Title & Live Search Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-[#C21818] uppercase tracking-widest">Catálogo Oficial</span>
                <h2 class="font-bebas text-4xl sm:text-5xl text-[#1F1F1F] tracking-wide uppercase">
                    EXPLORA NUESTRO <span class="text-[#C21818]">MENÚ</span>
                </h2>
                <p class="text-xs text-[#6B6255] mt-1">Hamburguesas, Chicken Sandwiches, Smash Burgers, Pastas, Crepas y Bebidas en Mérida.</p>
            </div>

            <!-- Search input -->
            <div class="relative min-w-[280px]">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="searchQuery" 
                    placeholder="🔍 Buscar hamburguesa, pasta, boneless..." 
                    class="w-full bg-[#FFFDF8] border border-[#EADDC9] rounded-2xl px-4 py-3 text-xs text-[#1F1F1F] placeholder-gray-400 focus:outline-none focus:border-[#C21818] shadow-sm"
                >
                @if(!empty($searchQuery))
                    <button wire:click="$set('searchQuery', '')" class="absolute right-3.5 top-3 text-gray-400 hover:text-black text-xs font-bold">
                        ✕
                    </button>
                @endif
            </div>
        </div>

        <!-- Sticky Fast-Food Category Filter Tabs (Warm Cream Styling) -->
        <div class="sticky top-20 z-30 bg-[#FDF8EE]/95 backdrop-blur-md py-3 -mx-4 px-4 sm:mx-0 sm:px-0 overflow-x-auto no-scrollbar border-b border-[#EADDC9]">
            <div class="flex items-center gap-2 min-w-max">
                <button 
                    wire:click="selectCategory('todos')"
                    class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all border flex items-center gap-2 cursor-pointer {{ $activeCategorySlug === 'todos' ? 'bg-[#C21818] text-[#FFFDF8] border-[#C21818] shadow-md scale-105' : 'bg-[#FFFDF8] text-[#524B40] border-[#EADDC9] hover:bg-[#FAF3E0]' }}"
                >
                    <span>🍔</span>
                    <span>Todos</span>
                    <span class="bg-black/10 px-1.5 py-0.5 rounded text-[10px] font-mono">{{ $products->count() }}</span>
                </button>

                @foreach($categories as $cat)
                    <button 
                        wire:click="selectCategory('{{ $cat->slug }}')"
                        class="px-4 py-2.5 rounded-2xl text-xs font-bold transition-all border flex items-center gap-2 cursor-pointer {{ $activeCategorySlug === $cat->slug ? 'bg-[#C21818] text-[#FFFDF8] border-[#C21818] shadow-md scale-105' : 'bg-[#FFFDF8] text-[#524B40] border-[#EADDC9] hover:bg-[#FAF3E0]' }}"
                    >
                        <span>
                            @if($cat->slug === 'entradas-snacks') 🍟
                            @elseif($cat->slug === 'hamburguesas') 🍔
                            @elseif($cat->slug === 'chicken-sandwich') 🍗
                            @elseif($cat->slug === 'smash-burgers') 🔥
                            @elseif($cat->slug === 'fettuccines-pasta') 🍝
                            @elseif($cat->slug === 'paquetes-combos') 🎁
                            @elseif($cat->slug === 'crepas') 🥞
                            @elseif($cat->slug === 'bebidas-postres') 🥤
                            @else 🍽️
                            @endif
                        </span>
                        <span>{{ $cat->name }}</span>
                        <span class="bg-black/10 px-1.5 py-0.5 rounded text-[10px] font-mono">{{ $cat->products_count }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Products Grid with Food Photos -->
        @if($products->isEmpty())
            <div class="text-center py-20 bg-[#FFFDF8] rounded-3xl border border-[#EADDC9] shadow-sm">
                <span class="text-5xl block mb-3">🔍</span>
                <h3 class="text-lg font-bold text-[#1F1F1F]">No se encontraron productos</h3>
                <p class="text-xs text-[#6B6255] mt-1">Intenta con otra búsqueda o selecciona otra categoría del menú.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="diner-card rounded-3xl overflow-hidden flex flex-col justify-between group">
                        
                        <!-- Top Food Image Card -->
                        <div class="relative h-48 w-full overflow-hidden bg-black/10">
                            <img 
                                src="{{ $product->image_url }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-1">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#1F1F1F] bg-[#FFFDF8]/90 backdrop-blur-md px-2.5 py-1 rounded-xl border border-[#EADDC9] shadow-sm">
                                    {{ $product->category->name }}
                                </span>
                            </div>

                            @if($product->badge)
                                <div class="absolute top-3 right-3">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-white bg-[#C21818] px-2.5 py-1 rounded-full shadow-md">
                                        {{ $product->badge }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Card Content Body -->
                        <div class="p-5 flex-grow space-y-2">
                            <h3 class="font-bold text-[#1F1F1F] text-base group-hover:text-[#C21818] transition-colors leading-snug">
                                {{ $product->name }}
                            </h3>
                            <p class="text-xs text-[#6B6255] leading-relaxed line-clamp-3">
                                {{ $product->description }}
                            </p>
                        </div>

                        <!-- Card Price & Action Button Footer -->
                        <div class="p-5 pt-0 flex items-center justify-between border-t border-[#EADDC9]/60 mt-2 pt-4">
                            <div>
                                <span class="text-[9px] text-[#6B6255] uppercase block font-bold">Precio</span>
                                <span class="text-2xl font-price font-extrabold text-[#C21818]">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </div>

                            @if($product->type === 'pasta_wizard')
                                <a 
                                    href="#arma-tu-pasta" 
                                    class="diner-button-gold px-4 py-2.5 rounded-2xl text-xs uppercase tracking-wider cursor-pointer"
                                >
                                    Armar Pasta 🍝
                                </a>
                            @else
                                <button 
                                    wire:click="$dispatch('open-product-modal', { productId: {{ $product->id }} })"
                                    class="diner-button-primary px-4 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider shadow-md flex items-center gap-1.5 cursor-pointer"
                                >
                                    @if($product->type === 'burger')
                                        <span>Personalizar 🍟</span>
                                    @elseif($product->type === 'chicken_sandwich')
                                        <span>Elegir Salsa 🍗</span>
                                    @else
                                        <span>Pedir 🛒</span>
                                    @endif
                                </button>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </section>

    <!-- ARMA TU PASTA WIZARD SECTION -->
    <section id="arma-tu-pasta" class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @livewire('public.pasta-builder-wizard')
    </section>

    <!-- SECTION: 7 SUCURSALES VERIFICADAS EN MÉRIDA -->
    <section id="sucursales" class="py-16 bg-[#FAF3E0] border-t border-[#EADDC9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-black text-[#C21818] uppercase tracking-widest">Presencia en Todo Mérida</span>
                <h2 class="font-bebas text-4xl sm:text-5xl text-[#1F1F1F] tracking-wide uppercase">
                    NUESTRAS <span class="text-[#C21818]">7 SUCURSALES</span>
                </h2>
                <p class="text-xs sm:text-sm text-[#524B40]">
                    Pide por WhatsApp para recoger (Pick-up) sin filas, visítanos en tu sucursal más cercana o solicita tu envío a domicilio.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($branches as $branch)
                    <div class="diner-card rounded-3xl p-6 flex flex-col justify-between space-y-5 relative overflow-hidden group hover:border-[#C21818] transition-all">
                        
                        <!-- Top Header -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center gap-1.5 bg-[#C21818]/10 text-[#C21818] border border-[#C21818]/20 text-[11px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                                    📍 {{ $branch->zone ?? $branch->city }}
                                </span>
                                <span class="text-xs font-bold text-[#F5A623] flex items-center gap-1 bg-[#F5A623]/10 px-2 py-0.5 rounded-full">
                                    ★ {{ $branch->rating ?? '4.2' }}
                                </span>
                            </div>

                            <div>
                                <h3 class="font-bebas text-2xl sm:text-3xl text-[#1F1F1F] group-hover:text-[#C21818] transition-colors leading-tight">
                                    {{ $branch->name }}
                                </h3>
                                <p class="text-xs text-[#6B6255] mt-1.5 flex items-start gap-1.5">
                                    <span class="text-base">🗺️</span>
                                    <span>{{ $branch->address }}</span>
                                </p>
                            </div>

                            <div class="bg-[#FDF8EE] p-3.5 rounded-2xl border border-[#EADDC9] space-y-1.5 text-xs text-[#524B40]">
                                <div class="flex items-center justify-between text-[11px]">
                                    <span class="text-[#6B6255]">Horario:</span>
                                    <span class="font-bold text-[#1F1F1F]">{{ $branch->schedule }}</span>
                                </div>
                                <div class="flex items-center justify-between text-[11px]">
                                    <span class="text-[#6B6255]">Teléfono:</span>
                                    <a href="tel:{{ $branch->phone }}" class="text-[#C21818] font-mono font-bold hover:underline">
                                        {{ $branch->phone }}
                                    </a>
                                </div>
                                <div class="flex items-center justify-between text-[11px]">
                                    <span class="text-[#6B6255]">WhatsApp:</span>
                                    <span class="text-[#17A085] font-mono font-bold">+{{ $branch->whatsapp_number }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons per Branch -->
                        <div class="space-y-2.5 pt-2">
                            <!-- Direct WhatsApp Button -->
                            <a 
                                href="{{ $branch->whatsapp_url }}" 
                                target="_blank" 
                                class="w-full diner-button-aqua text-white py-3 px-4 rounded-2xl text-xs uppercase tracking-wider shadow-md flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span class="text-base">💬</span>
                                <span>Pedir por WhatsApp</span>
                            </a>

                            <div class="grid grid-cols-2 gap-2">
                                <a 
                                    href="{{ $branch->google_maps_url }}" 
                                    target="_blank" 
                                    class="bg-[#FDF8EE] hover:bg-[#FAF3E0] text-[#1F1F1F] border border-[#EADDC9] py-2 px-3 rounded-xl text-xs font-bold text-center flex items-center justify-center gap-1 transition-colors"
                                >
                                    <span>📍</span>
                                    <span>Maps</span>
                                </a>
                                <a 
                                    href="tel:{{ $branch->phone }}" 
                                    class="bg-[#FDF8EE] hover:bg-[#FAF3E0] text-[#1F1F1F] border border-[#EADDC9] py-2 px-3 rounded-xl text-xs font-bold text-center flex items-center justify-center gap-1 transition-colors"
                                >
                                    <span>📞</span>
                                    <span>Llamar</span>
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- MODAL POPUP FOR CUSTOMIZATION -->
    @livewire('public.product-modal')
</div>
