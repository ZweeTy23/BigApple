<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Panel Admin | Big Apple Diner' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logobigapple.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-[#FDF8EE] bg-cream-pattern text-[#1F1F1F] min-h-screen flex flex-col font-sans selection:bg-[#C21818] selection:text-white antialiased">
    
    <!-- Admin Top Navbar (Warm Cream & Diner Red) -->
    <header class="bg-[#FFFDF8]/95 backdrop-blur-md border-b border-[#EADDC9] sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 shrink-0">
                <a href="/admin" class="flex items-center gap-2.5 shrink-0 group">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-[#FFFDF8] border border-[#EADDC9] flex items-center justify-center p-1 shadow-sm shrink-0 overflow-hidden">
                        <img src="{{ asset('images/logobigapple.png') }}" alt="Big Apple Diner" class="w-full h-full max-h-full max-w-full object-contain">
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="text-[9px] font-black tracking-widest text-[#17A085] uppercase">7 SUCURSALES MÉRIDA</span>
                        <span class="font-bebas text-[#1F1F1F] text-xl sm:text-2xl tracking-wide">
                            BIG APPLE <span class="text-[#C21818]">DINER</span> <span class="text-[#17A085] text-xs font-normal">ADMIN</span>
                        </span>
                    </div>
                </a>

                @auth
                    @if(Auth::user()->isSuperAdmin())
                        <span class="hidden xl:inline-block bg-[#C21818]/10 text-[#C21818] border border-[#C21818]/25 text-[10px] font-black px-2.5 py-1 rounded-full uppercase shrink-0">
                            👑 Super Admin
                        </span>
                    @else
                        <span class="hidden xl:inline-block bg-[#17A085]/10 text-[#17A085] border border-[#17A085]/30 text-[10px] font-black px-2.5 py-1 rounded-full uppercase shrink-0">
                            📍 {{ Auth::user()->branch->name ?? 'Sucursal' }}
                        </span>
                    @endif
                @endauth
            </div>

            @auth
                <!-- Navigation Items -->
                <nav class="flex items-center gap-1 sm:gap-2 text-xs font-extrabold">
                    <a 
                        href="/admin" 
                        class="px-3 py-2 rounded-xl transition-all {{ request()->is('admin') ? 'bg-[#C21818] text-[#FFFDF8] shadow-sm' : 'text-[#524B40] hover:text-[#C21818] hover:bg-[#FAF3E0]' }}"
                    >
                        📊 Resumen
                    </a>

                    <a 
                        href="/admin/operaciones" 
                        class="px-3 py-2 rounded-xl transition-all {{ request()->is('admin/operaciones*') ? 'bg-[#C21818] text-[#FFFDF8] shadow-sm' : 'text-[#524B40] hover:text-[#C21818] hover:bg-[#FAF3E0]' }}"
                    >
                        ⚙️ Operaciones & Caja
                    </a>

                    <a 
                        href="/admin/productos" 
                        class="px-3 py-2 rounded-xl transition-all {{ request()->is('admin/productos*') ? 'bg-[#C21818] text-[#FFFDF8] shadow-sm' : 'text-[#524B40] hover:text-[#C21818] hover:bg-[#FAF3E0]' }}"
                    >
                        🍔 Menú & Precios
                    </a>

                    <a 
                        href="/admin/ordenes" 
                        class="px-3 py-2 rounded-xl transition-all {{ request()->is('admin/ordenes*') ? 'bg-[#C21818] text-[#FFFDF8] shadow-sm' : 'text-[#524B40] hover:text-[#C21818] hover:bg-[#FAF3E0]' }}"
                    >
                        📦 Pedidos
                    </a>

                    <!-- User and Logout -->
                    <div class="flex items-center gap-2 border-l border-[#EADDC9] pl-2 sm:pl-3">
                        <div class="hidden lg:flex flex-col text-right leading-none">
                            <span class="text-[#1F1F1F] text-xs font-bold font-mono">{{ Auth::user()->username ?? Auth::user()->name }}</span>
                            <span class="text-[9px] text-[#C21818] font-bold">{{ Auth::user()->role === 'superadmin' ? 'Super Admin' : 'Gerente' }}</span>
                        </div>

                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                            @csrf
                            <button 
                                type="submit" 
                                title="Cerrar Sesión" 
                                class="bg-red-50 hover:bg-red-100 text-[#C21818] px-2.5 py-1.5 rounded-xl border border-red-200 text-xs font-bold transition-colors flex items-center gap-1 cursor-pointer"
                            >
                                <span>🚪</span>
                                <span class="hidden sm:inline">Salir</span>
                            </button>
                        </form>

                        <a 
                            href="/" 
                            target="_blank" 
                            title="Ver Tienda Pública" 
                            class="bg-[#FDF8EE] hover:bg-[#FAF3E0] text-[#524B40] px-2.5 py-1.5 rounded-xl border border-[#EADDC9] text-xs font-bold transition-colors flex items-center gap-1"
                        >
                            <span>🌐</span>
                            <span class="hidden sm:inline">Tienda</span>
                        </a>
                    </div>
                </nav>
            @else
                <a href="/" class="text-xs text-[#6B6255] hover:text-[#C21818] font-bold">
                    ← Volver a la Tienda
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <footer class="border-t border-[#EADDC9] py-5 text-center text-xs text-[#8C8070]">
        <p>Big Apple Diner © {{ date('Y') }} • Sistema Integral de Operaciones Mérida, Yucatán (7 Sucursales)</p>
    </footer>

    @livewireScripts
</body>
</html>
