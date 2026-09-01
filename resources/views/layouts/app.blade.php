<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Big Apple Diner | Comida Rápida, Hamburguesas & Pastas en Mérida' }}</title>
    <meta name="description" content="Big Apple Diner en Mérida, Yucatán. 7 sucursales: Francisco de Montejo, Zona Dorada, Ciudad Caucel, Plaza Royal Las Américas, Opichén, Serapio Rendón Sur y Plaza Mura Xtabay. Hamburguesas artesanales, boneless, smash burgers y pastas al gusto.">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-[#FDF8EE] bg-cream-pattern text-[#1F1F1F] min-h-screen flex flex-col font-sans antialiased selection:bg-[#C21818] selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-[#C21818] via-[#8E0E15] to-[#E85D04] text-[#FFFDF8] text-xs font-bold py-2.5 px-4 text-center tracking-wide flex items-center justify-between shadow-md">
        <div class="hidden md:flex items-center gap-2">
            <span class="bg-[#F5A623] text-[#1F1F1F] text-[10px] px-2 py-0.5 rounded-full font-black uppercase">7 Sucursales</span>
            <span class="text-[11px] text-[#FDF8EE]/90">Mérida, Yucatán</span>
        </div>
        <div class="flex items-center justify-center gap-2 mx-auto md:mx-0">
            <span>🗽</span>
            <span class="uppercase tracking-wider">MULTICULTURAL TASTE • Servicio en Sucursal, Pick-up & Domicilio</span>
        </div>
        <div class="hidden md:flex items-center gap-3">
            <a href="https://www.facebook.com/BigappleMid" target="_blank" class="hover:text-[#F5A623] text-xs font-bold flex items-center gap-1 transition-colors">
                <span>📘</span>
                <span>facebook.com/BigappleMid</span>
            </a>
        </div>
    </div>

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 bg-[#FFFDF8]/95 backdrop-blur-md border-b border-[#EADDC9] shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#C21818] via-[#F5A623] to-[#C21818] p-0.5 shadow-md group-hover:scale-105 transition-transform duration-300">
                    <div class="w-full h-full bg-[#FFFDF8] rounded-2xl flex items-center justify-center relative overflow-hidden">
                        <span class="text-2xl font-black select-none">🍎</span>
                    </div>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="text-[10px] font-black tracking-widest text-[#17A085] uppercase">AMERICAN DINER</span>
                    <div class="font-bebas text-2xl md:text-3xl tracking-wide text-[#1F1F1F] flex items-center gap-1.5">
                        BIG APPLE <span class="text-[#C21818]">DINER</span>
                    </div>
                    <p class="text-[9px] text-[#8E0E15] font-bold tracking-wider uppercase">Mérida, Yucatán</p>
                </div>
            </a>

            <!-- Navigation Items & Action Buttons -->
            <div class="flex items-center gap-3 sm:gap-4">
                <nav class="hidden lg:flex items-center gap-6 text-xs font-extrabold text-[#4A443B] uppercase tracking-wider">
                    <a href="#promos" class="hover:text-[#C21818] transition-colors flex items-center gap-1.5">
                        <span>🔥</span> Promociones
                    </a>
                    <a href="#menu" class="hover:text-[#C21818] transition-colors flex items-center gap-1.5">
                        <span>🍔</span> Menú
                    </a>
                    <a href="#arma-tu-pasta" class="hover:text-[#E85D04] transition-colors flex items-center gap-1.5">
                        <span>🍝</span> Arma tu Pasta
                    </a>
                    <a href="#sucursales" class="hover:text-[#17A085] transition-colors flex items-center gap-1.5">
                        <span>📍</span> 7 Sucursales
                    </a>
                </nav>

                <!-- Admin Link (Only visible if already logged in) -->
                @auth
                    <a href="/admin" class="inline-flex items-center gap-1.5 text-xs bg-[#C21818]/10 hover:bg-[#C21818]/20 text-[#C21818] px-3 py-2 rounded-xl transition-colors font-bold border border-[#C21818]/20 shadow-sm">
                        <span>⚙️ Panel Admin</span>
                    </a>
                @endauth

                <!-- Cart Button Livewire Dispatcher -->
                <button 
                    x-data 
                    @click="$dispatch('toggle-cart')" 
                    class="relative diner-button-primary px-5 py-3 rounded-2xl text-[#FFFDF8] font-extrabold text-xs sm:text-sm flex items-center gap-2 shadow-lg cursor-pointer"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="hidden sm:inline uppercase tracking-wider">Tu Orden</span>
                    @livewire('public.cart-counter')
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Slide-over Cart Component -->
    @livewire('public.cart-component')

    <!-- FLOATING MULTI-BRANCH WHATSAPP WIDGET (7 SUCURSALES) -->
    <div 
        x-data="{ open: false }" 
        class="fixed bottom-6 left-6 z-40"
    >
        <!-- WhatsApp Popup Menu -->
        <div 
            x-show="open" 
            @click.away="open = false" 
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="mb-3 w-84 max-h-[75vh] overflow-y-auto bg-[#FFFDF8] rounded-3xl p-5 border border-[#17A085]/40 shadow-2xl space-y-3"
            style="display: none;"
        >
            <div class="flex items-center justify-between border-b border-[#EADDC9] pb-2">
                <div class="flex items-center gap-2">
                    <span class="text-xl">💬</span>
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-wider text-[#1F1F1F]">WhatsApp Oficial</h4>
                        <p class="text-[10px] text-[#17A085] font-bold">Elige tu sucursal más cercana:</p>
                    </div>
                </div>
                <button @click="open = false" class="text-gray-400 hover:text-black text-xs font-bold">✕</button>
            </div>

            <div class="space-y-1.5 text-xs">
                <!-- 1. Francisco de Montejo -->
                <a 
                    href="https://wa.me/529993541087?text=Hola%20Big%20Apple%20Francisco%20de%20Montejo,%20quiero%20hacer%20un%20pedido." 
                    target="_blank"
                    class="block p-2.5 rounded-2xl bg-[#FDF8EE] hover:bg-[#17A085]/10 border border-[#EADDC9] hover:border-[#17A085] transition-all group"
                >
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F1F1F] group-hover:text-[#17A085]">📍 Francisco de Montejo</span>
                        <span class="text-[10px] bg-[#17A085] text-white px-1.5 py-0.5 rounded font-bold">Pedir</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-0.5">Calle 61 #195 • 4.3 ⭐</p>
                </a>

                <!-- 2. Dorada -->
                <a 
                    href="https://wa.me/529991351212?text=Hola%20Big%20Apple%20Dorada,%20quiero%20hacer%20un%20pedido." 
                    target="_blank"
                    class="block p-2.5 rounded-2xl bg-[#FDF8EE] hover:bg-[#17A085]/10 border border-[#EADDC9] hover:border-[#17A085] transition-all group"
                >
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F1F1F] group-hover:text-[#17A085]">📍 Villas Zona Dorada</span>
                        <span class="text-[10px] bg-[#17A085] text-white px-1.5 py-0.5 rounded font-bold">Pedir</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-0.5">Calle 47 #553 x 102 • 3.9 ⭐</p>
                </a>

                <!-- 3. Caucel -->
                <a 
                    href="https://wa.me/529994924327?text=Hola%20Big%20Apple%20Caucel,%20quiero%20hacer%20un%20pedido." 
                    target="_blank"
                    class="block p-2.5 rounded-2xl bg-[#FDF8EE] hover:bg-[#17A085]/10 border border-[#EADDC9] hover:border-[#17A085] transition-all group"
                >
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F1F1F] group-hover:text-[#17A085]">📍 Ciudad Caucel</span>
                        <span class="text-[10px] bg-[#17A085] text-white px-1.5 py-0.5 rounded font-bold">Pedir</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-0.5">Calle 70 #750 por 93 • 3.9 ⭐</p>
                </a>

                <!-- 4. Plaza Royal Las Américas -->
                <a 
                    href="https://wa.me/529992151522?text=Hola%20Big%20Apple%20Plaza%20Royal%20Las%20Américas,%20quiero%20hacer%20un%20pedido." 
                    target="_blank"
                    class="block p-2.5 rounded-2xl bg-[#FDF8EE] hover:bg-[#17A085]/10 border border-[#EADDC9] hover:border-[#17A085] transition-all group"
                >
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F1F1F] group-hover:text-[#17A085]">📍 Las Américas Plaza Royal</span>
                        <span class="text-[10px] bg-[#17A085] text-white px-1.5 py-0.5 rounded font-bold">Pedir</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-0.5">Calle 69 N553-L16, Dzityá • 4.7 ⭐</p>
                </a>

                <!-- 5. Girasoles de Opichén -->
                <a 
                    href="https://wa.me/529991481508?text=Hola%20Big%20Apple%20Opichén,%20quiero%20hacer%20un%20pedido." 
                    target="_blank"
                    class="block p-2.5 rounded-2xl bg-[#FDF8EE] hover:bg-[#17A085]/10 border border-[#EADDC9] hover:border-[#17A085] transition-all group"
                >
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F1F1F] group-hover:text-[#17A085]">📍 Girasoles de Opichén</span>
                        <span class="text-[10px] bg-[#17A085] text-white px-1.5 py-0.5 rounded font-bold">Pedir</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-0.5">Calle 81 Diag. #1192 • 4.3 ⭐</p>
                </a>

                <!-- 6. Sur (Serapio Rendón) -->
                <a 
                    href="https://wa.me/529994497831?text=Hola%20Big%20Apple%20Sur,%20quiero%20hacer%20un%20pedido." 
                    target="_blank"
                    class="block p-2.5 rounded-2xl bg-[#FDF8EE] hover:bg-[#17A085]/10 border border-[#EADDC9] hover:border-[#17A085] transition-all group"
                >
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F1F1F] group-hover:text-[#17A085]">📍 Sur (Serapio Rendón II)</span>
                        <span class="text-[10px] bg-[#17A085] text-white px-1.5 py-0.5 rounded font-bold">Pedir</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-0.5">Calle 131 #143 x 44 y 46 • 3.9 ⭐</p>
                </a>

                <!-- 7. Xtabay Plaza Mura -->
                <a 
                    href="https://wa.me/529991495947?text=Hola%20Big%20Apple%20Xtabay%20Plaza%20Mura,%20quiero%20hacer%20un%20pedido." 
                    target="_blank"
                    class="block p-2.5 rounded-2xl bg-[#FDF8EE] hover:bg-[#17A085]/10 border border-[#EADDC9] hover:border-[#17A085] transition-all group"
                >
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-[#1F1F1F] group-hover:text-[#17A085]">📍 Xtabay Plaza Mura</span>
                        <span class="text-[10px] bg-[#17A085] text-white px-1.5 py-0.5 rounded font-bold">Pedir</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-0.5">Calle 39 Local 6, Leandro Valle • 4.1 ⭐</p>
                </a>
            </div>
        </div>

        <!-- Main Float Button Trigger -->
        <button 
            @click="open = !open" 
            type="button" 
            class="diner-button-aqua text-white p-3.5 sm:px-5 sm:py-3.5 rounded-full shadow-2xl flex items-center gap-2 cursor-pointer relative"
        >
            <span class="text-xl">💬</span>
            <span class="hidden sm:inline font-black text-xs uppercase tracking-wider">Pedir por WhatsApp (7 Sucursales)</span>
            <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-[#17A085]"></span>
            </span>
        </button>
    </div>

    <!-- Enhanced Warm Diner Footer -->
    <footer class="bg-[#1F1F1F] border-t border-[#3A352F] text-[#EADDC9] text-xs py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- Brand & Slogan -->
                <div class="space-y-3 md:col-span-2">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🍔</span>
                        <div class="font-bebas text-3xl tracking-wide text-[#FFFDF8]">
                            BIG APPLE <span class="text-[#C21818]">DINER</span>
                        </div>
                    </div>
                    <p class="text-xs text-[#C8BAA4] leading-relaxed max-w-md">
                        Comida rápida gourmet al estilo American Diner en Mérida, Yucatán. 7 sucursales con hamburguesas artesanales con papas cajún, pollo crujiente, smash burgers, fettuccines al gusto y crepas.
                    </p>

                    <!-- Order Modalities -->
                    <div class="flex flex-wrap gap-2 pt-2">
                        <span class="text-[11px] bg-white/5 border border-white/10 px-3 py-1 rounded-xl text-[#F5A623] font-bold">
                            🍽️ Consumo en Sucursal
                        </span>
                        <span class="text-[11px] bg-white/5 border border-white/10 px-3 py-1 rounded-xl text-[#17A085] font-bold">
                            🛍️ Pick-up vía WhatsApp
                        </span>
                        <span class="text-[11px] bg-white/5 border border-white/10 px-3 py-1 rounded-xl text-[#FFFDF8] font-bold">
                            🛵 Domicilio: Directo • Uber Eats • Rappi • DiDi Food
                        </span>
                    </div>

                    <div class="pt-2">
                        <a href="https://www.facebook.com/BigappleMid" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-[#17A085] hover:text-[#F5A623] transition-colors">
                            <span>📘</span>
                            <span>Facebook Oficial: facebook.com/BigappleMid</span>
                        </a>
                    </div>
                </div>

                <!-- Sucursales Norte / Poniente -->
                <div class="space-y-2 bg-[#292522] p-5 rounded-2xl border border-white/5 text-[11px]">
                    <span class="text-xs font-black uppercase text-[#F5A623] tracking-wider block">📍 Norte & Poniente</span>
                    <p class="text-white font-bold">Montejo • Dorada • Caucel • Royal</p>
                    <p class="text-[#AFA28F]">🕒 L-J: 11:00 – 22:30 | V-D: 11:00 – 23:30</p>
                    <p class="text-[#AFA28F]">Dzityá Plaza Royal: Cierra 11:00 PM L-J</p>
                </div>

                <!-- Sucursales Sur / Oriente -->
                <div class="space-y-2 bg-[#292522] p-5 rounded-2xl border border-white/5 text-[11px]">
                    <span class="text-xs font-black uppercase text-[#F5A623] tracking-wider block">📍 Sur & Oriente</span>
                    <p class="text-white font-bold">Opichén • Sur Serapio • Xtabay</p>
                    <p class="text-[#AFA28F]">🕒 L-J: 11:00 – 22:30 | V-D: 11:00 – 23:30</p>
                    <p class="text-[#AFA28F]">Plaza Mura (Leandro Valle / Macroplaza)</p>
                </div>

            </div>

            <div class="border-t border-[#3A352F] pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-[#8C8070] text-[11px]">
                <p>© {{ date('Y') }} Big Apple Diner Mérida, Yuc. Todos los derechos reservados.</p>
                <div class="flex items-center gap-4">
                    <a href="#promos" class="hover:text-white transition-colors">Promociones</a>
                    <a href="#menu" class="hover:text-white transition-colors">Menú</a>
                    <a href="#sucursales" class="hover:text-white transition-colors">Sucursales</a>
                    <a href="https://www.facebook.com/BigappleMid" target="_blank" class="hover:text-white transition-colors">Facebook</a>
                </div>
            </div>

        </div>
    </footer>

    @livewireScripts
</body>
</html>
