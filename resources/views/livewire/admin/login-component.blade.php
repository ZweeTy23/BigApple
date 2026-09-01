<div class="min-h-screen bg-[#FDF8EE] bg-cream-pattern flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-12 relative overflow-hidden">
    
    <div class="w-full max-w-lg space-y-6 relative z-10">
        
        <!-- Brand Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-[#C21818] via-[#D11919] to-[#8E0E15] shadow-xl border-2 border-[#F5A623] p-4 transform -rotate-2 hover:rotate-0 transition-transform duration-300">
                <span class="text-4xl select-none">🍔</span>
            </div>
            <div>
                <h1 class="font-bebas text-4xl sm:text-5xl text-[#1F1F1F] tracking-wide uppercase drop-shadow-sm">
                    Big Apple <span class="text-[#C21818]">Diner</span>
                </h1>
                <p class="text-xs uppercase tracking-widest text-[#C21818] font-black">
                    Panel de Administración • 7 Sucursales Mérida
                </p>
            </div>
        </div>

        <!-- Quick Profile Selector (7 Sucursales + Super Admin) -->
        <div class="bg-[#FFFDF8] p-4 rounded-3xl border border-[#EADDC9] space-y-3 shadow-md">
            <div class="flex items-center justify-between text-xs text-[#524B40] font-bold px-1">
                <span class="uppercase tracking-wider">⚡ Acceso Rápido por Perfil:</span>
                <span class="text-[10px] text-[#C21818]">Click para autocompletar</span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-left max-h-56 overflow-y-auto pr-1">
                <!-- Super Admin -->
                <button 
                    type="button" 
                    wire:click="fillUser('admin')"
                    class="sm:col-span-2 p-2.5 rounded-2xl border text-left transition-all cursor-pointer {{ $login === 'admin' ? 'bg-[#C21818]/10 border-[#C21818] text-[#1F1F1F]' : 'bg-[#FDF8EE] border-[#EADDC9] text-[#524B40] hover:border-[#C21818]' }}"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span>👑</span>
                            <div>
                                <div class="text-xs font-black text-[#1F1F1F]">Admin General (7 Sucursales)</div>
                                <div class="text-[10px] text-gray-500 font-mono">Usuario: <strong class="text-[#C21818]">admin</strong></div>
                            </div>
                        </div>
                        <span class="text-[10px] bg-[#C21818] text-white font-bold px-2 py-0.5 rounded-full">Global</span>
                    </div>
                </button>

                <!-- Montejo -->
                <button 
                    type="button" 
                    wire:click="fillUser('gerente_montejo')"
                    class="p-2.5 rounded-2xl border text-left transition-all cursor-pointer {{ $login === 'gerente_montejo' ? 'bg-[#17A085]/10 border-[#17A085]' : 'bg-[#FDF8EE] border-[#EADDC9] hover:border-[#17A085]' }}"
                >
                    <div class="text-xs font-bold text-[#1F1F1F]">📍 Fco. de Montejo</div>
                    <div class="text-[10px] text-gray-500 font-mono">Usuario: <span class="text-[#17A085] font-bold">gerente_montejo</span></div>
                </button>

                <!-- Dorada -->
                <button 
                    type="button" 
                    wire:click="fillUser('gerente_dorada')"
                    class="p-2.5 rounded-2xl border text-left transition-all cursor-pointer {{ $login === 'gerente_dorada' ? 'bg-[#17A085]/10 border-[#17A085]' : 'bg-[#FDF8EE] border-[#EADDC9] hover:border-[#17A085]' }}"
                >
                    <div class="text-xs font-bold text-[#1F1F1F]">📍 Villas Zona Dorada</div>
                    <div class="text-[10px] text-gray-500 font-mono">Usuario: <span class="text-[#17A085] font-bold">gerente_dorada</span></div>
                </button>

                <!-- Caucel -->
                <button 
                    type="button" 
                    wire:click="fillUser('gerente_caucel')"
                    class="p-2.5 rounded-2xl border text-left transition-all cursor-pointer {{ $login === 'gerente_caucel' ? 'bg-[#17A085]/10 border-[#17A085]' : 'bg-[#FDF8EE] border-[#EADDC9] hover:border-[#17A085]' }}"
                >
                    <div class="text-xs font-bold text-[#1F1F1F]">📍 Ciudad Caucel</div>
                    <div class="text-[10px] text-gray-500 font-mono">Usuario: <span class="text-[#17A085] font-bold">gerente_caucel</span></div>
                </button>

                <!-- Plaza Royal -->
                <button 
                    type="button" 
                    wire:click="fillUser('gerente_royal')"
                    class="p-2.5 rounded-2xl border text-left transition-all cursor-pointer {{ $login === 'gerente_royal' ? 'bg-[#17A085]/10 border-[#17A085]' : 'bg-[#FDF8EE] border-[#EADDC9] hover:border-[#17A085]' }}"
                >
                    <div class="text-xs font-bold text-[#1F1F1F]">📍 Américas Plaza Royal</div>
                    <div class="text-[10px] text-gray-500 font-mono">Usuario: <span class="text-[#17A085] font-bold">gerente_royal</span></div>
                </button>

                <!-- Opichén -->
                <button 
                    type="button" 
                    wire:click="fillUser('gerente_opichen')"
                    class="p-2.5 rounded-2xl border text-left transition-all cursor-pointer {{ $login === 'gerente_opichen' ? 'bg-[#17A085]/10 border-[#17A085]' : 'bg-[#FDF8EE] border-[#EADDC9] hover:border-[#17A085]' }}"
                >
                    <div class="text-xs font-bold text-[#1F1F1F]">📍 Girasoles Opichén</div>
                    <div class="text-[10px] text-gray-500 font-mono">Usuario: <span class="text-[#17A085] font-bold">gerente_opichen</span></div>
                </button>

                <!-- Sur -->
                <button 
                    type="button" 
                    wire:click="fillUser('gerente_sur')"
                    class="p-2.5 rounded-2xl border text-left transition-all cursor-pointer {{ $login === 'gerente_sur' ? 'bg-[#17A085]/10 border-[#17A085]' : 'bg-[#FDF8EE] border-[#EADDC9] hover:border-[#17A085]' }}"
                >
                    <div class="text-xs font-bold text-[#1F1F1F]">📍 Sur Serapio Rendón</div>
                    <div class="text-[10px] text-gray-500 font-mono">Usuario: <span class="text-[#17A085] font-bold">gerente_sur</span></div>
                </button>

                <!-- Xtabay -->
                <button 
                    type="button" 
                    wire:click="fillUser('gerente_xtabay')"
                    class="p-2.5 rounded-2xl border text-left transition-all cursor-pointer {{ $login === 'gerente_xtabay' ? 'bg-[#17A085]/10 border-[#17A085]' : 'bg-[#FDF8EE] border-[#EADDC9] hover:border-[#17A085]' }}"
                >
                    <div class="text-xs font-bold text-[#1F1F1F]">📍 Xtabay Plaza Mura</div>
                    <div class="text-[10px] text-gray-500 font-mono">Usuario: <span class="text-[#17A085] font-bold">gerente_xtabay</span></div>
                </button>
            </div>
        </div>

        <!-- Login Card Form -->
        <div class="bg-[#FFFDF8] border border-[#EADDC9] rounded-3xl p-7 shadow-xl space-y-5">
            
            <form wire:submit.prevent="authenticate" class="space-y-4">
                
                @if($errorMessage)
                    <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-[#C21818] text-xs flex items-center gap-2.5 font-bold">
                        <span class="text-base">⚠️</span>
                        <span>{{ $errorMessage }}</span>
                    </div>
                @endif

                <!-- Username Input -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-[#1F1F1F] uppercase tracking-wider">
                        Nombre de Usuario o Correo
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 text-sm">👤</span>
                        <input 
                            type="text" 
                            wire:model="login"
                            placeholder="admin / gerente_montejo / gerente_dorada..." 
                            class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl pl-10 pr-4 py-3 text-sm text-[#1F1F1F] placeholder-gray-400 focus:outline-none focus:border-[#C21818] transition-all"
                            required
                        >
                    </div>
                    @error('login') <span class="text-[11px] text-red-500 font-semibold">{{ $message }}</span> @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-[#1F1F1F] uppercase tracking-wider">
                        Contraseña de Acceso
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 text-sm">🔒</span>
                        <input 
                            type="password" 
                            wire:model="password" 
                            placeholder="••••••••" 
                            class="w-full bg-[#FDF8EE] border border-[#EADDC9] rounded-xl pl-10 pr-4 py-3 text-sm text-[#1F1F1F] placeholder-gray-400 focus:outline-none focus:border-[#C21818] transition-all"
                            required
                        >
                    </div>
                    @error('password') <span class="text-[11px] text-red-500 font-semibold">{{ $message }}</span> @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 text-[#524B40] cursor-pointer">
                        <input type="checkbox" wire:model="remember" class="rounded border-[#EADDC9] text-[#C21818]">
                        <span>Recordar sesión</span>
                    </label>
                    <span class="text-[11px] text-[#6B6255]">Contraseña de prueba: <strong class="text-[#C21818] font-mono">123</strong></span>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full py-3.5 px-4 rounded-xl font-black text-xs text-white diner-button-primary uppercase tracking-wider flex items-center justify-center gap-2 cursor-pointer shadow-md"
                >
                    <span wire:loading.remove>Entrar al Panel Administrativo →</span>
                    <span wire:loading>Verificando credenciales...</span>
                </button>

            </form>

        </div>

        <!-- Back to Public Menu -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#524B40] hover:text-[#C21818] transition-colors">
                <span>←</span>
                <span>Volver al Menú Público de Hamburguesas</span>
            </a>
        </div>

    </div>
</div>
