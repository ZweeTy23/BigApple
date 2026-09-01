<div id="arma-tu-pasta" class="bg-[#FFFDF8] rounded-3xl p-6 sm:p-10 border border-[#EADDC9] shadow-lg relative overflow-hidden">
    
    <div class="relative z-10">
        <!-- Header Title -->
        <div class="text-center max-w-2xl mx-auto mb-8 space-y-2">
            <span class="inline-block bg-[#C21818]/10 text-[#C21818] text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider border border-[#C21818]/20">
                🍝 Módulo Interactivo Wizard
            </span>
            <h2 class="font-bebas text-4xl sm:text-5xl text-[#1F1F1F] tracking-wide uppercase">
                ARMA TU <span class="text-[#C21818]">PASTA</span> AL GUSTO
            </h2>
            <p class="text-xs sm:text-sm text-[#524B40]">
                Personaliza tu Fettuccine artesanal en 4 sencillos pasos. Selecciona tamaño, salsa, proteína y tus 3 ingredientes favoritos.
            </p>
        </div>

        <!-- Wizard Stepper Navigation -->
        <div class="grid grid-cols-4 gap-2 mb-8 max-w-3xl mx-auto">
            @foreach([
                1 => '1. Tamaño',
                2 => '2. Salsa',
                3 => '3. Proteína',
                4 => '4. 3 Ingredientes'
            ] as $stepNum => $stepLabel)
                <button 
                    wire:click="goToStep({{ $stepNum }})"
                    class="py-3 px-2 rounded-2xl text-xs font-bold transition-all flex flex-col sm:flex-row items-center justify-center gap-2 border cursor-pointer {{ $currentStep === $stepNum ? 'bg-[#C21818] text-white border-[#C21818] shadow-md' : ($currentStep > $stepNum ? 'bg-[#17A085]/10 text-[#17A085] border-[#17A085]/30' : 'bg-[#FDF8EE] text-[#524B40] border-[#EADDC9] hover:bg-[#FAF3E0]') }}"
                >
                    <span>{{ $stepLabel }}</span>
                    @if($currentStep > $stepNum)
                        <span class="text-[10px] font-bold">✓</span>
                    @endif
                </button>
            @endforeach
        </div>

        <!-- Step Content Panels -->
        <div class="max-w-2xl mx-auto bg-[#FDF8EE] p-6 sm:p-8 rounded-3xl border border-[#EADDC9]">
            
            <!-- STEP 1: TAMAÑO -->
            @if($currentStep === 1)
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-[#1F1F1F] flex items-center gap-2">
                        <span>Paso 1:</span> Selecciona el Tamaño de tu Pasta
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button 
                            type="button"
                            wire:click="selectSize('Individual', 149)"
                            class="p-5 rounded-2xl border text-left transition-all flex flex-col justify-between cursor-pointer {{ $size === 'Individual' ? 'border-[#C21818] bg-white text-[#1F1F1F] shadow-md' : 'border-[#EADDC9] bg-[#FFFDF8] text-[#524B40] hover:bg-white' }}"
                        >
                            <div>
                                <span class="font-bold text-base block text-[#1F1F1F]">Porción Individual</span>
                                <span class="text-xs text-[#6B6255] mt-1 block">Ideal para 1 persona. Incluye 3 ingredientes.</span>
                            </div>
                            <div class="mt-4 font-price font-extrabold text-[#C21818] text-2xl">
                                $149.00
                            </div>
                        </button>

                        <button 
                            type="button"
                            wire:click="selectSize('Pareja', 269)"
                            class="p-5 rounded-2xl border text-left transition-all flex flex-col justify-between cursor-pointer {{ $size === 'Pareja' ? 'border-[#C21818] bg-white text-[#1F1F1F] shadow-md' : 'border-[#EADDC9] bg-[#FFFDF8] text-[#524B40] hover:bg-white' }}"
                        >
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-base text-[#1F1F1F]">Porción Pareja</span>
                                    <span class="bg-[#C21818] text-white text-[10px] px-2 py-0.5 rounded font-bold">Doble Porción</span>
                                </div>
                                <span class="text-xs text-[#6B6255] mt-1 block">Porción generosa para 2 personas. Incluye 3 ingredientes.</span>
                            </div>
                            <div class="mt-4 font-price font-extrabold text-[#C21818] text-2xl">
                                $269.00
                            </div>
                        </button>
                    </div>
                </div>
            @endif

            <!-- STEP 2: SALSA -->
            @if($currentStep === 2)
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-[#1F1F1F] flex items-center gap-2">
                        <span>Paso 2:</span> Elige la Especialidad o Salsa
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach($availableSauces as $s)
                            <button 
                                type="button"
                                wire:click="selectSauce('{{ $s }}')"
                                class="p-4 rounded-2xl border text-center transition-all flex flex-col items-center justify-center gap-2 cursor-pointer {{ $sauce === $s ? 'border-[#C21818] bg-white text-[#C21818] font-bold shadow-md' : 'border-[#EADDC9] bg-[#FFFDF8] text-[#524B40] hover:bg-white' }}"
                            >
                                <span class="text-2xl">
                                    @if($s === 'Chipotle') 🌶️ @elseif($s === 'Alfredo') 🧀 @else 🧈 @endif
                                </span>
                                <span class="text-xs font-bold">{{ $s }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- STEP 3: PROTEÍNA -->
            @if($currentStep === 3)
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-[#1F1F1F] flex items-center gap-2">
                        <span>Paso 3:</span> Escoge tu Proteína (1 a elegir)
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($availableProteins as $p)
                            <button 
                                type="button"
                                wire:click="selectProtein('{{ $p }}')"
                                class="p-4 rounded-2xl border text-left transition-all flex items-center gap-3 cursor-pointer {{ $protein === $p ? 'border-[#17A085] bg-white text-[#17A085] font-bold shadow-sm' : 'border-[#EADDC9] bg-[#FFFDF8] text-[#524B40] hover:bg-white' }}"
                            >
                                <span class="w-4 h-4 rounded-full border flex items-center justify-center text-[10px] {{ $protein === $p ? 'border-[#17A085] bg-[#17A085] text-white font-bold' : 'border-gray-400' }}">
                                    @if($protein === $p) ✓ @endif
                                </span>
                                <span class="text-xs font-bold">{{ $p }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- STEP 4: 3 INGREDIENTES -->
            @if($currentStep === 4)
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-bold text-[#1F1F1F]">
                            <span>Paso 4:</span> Escoge 3 Ingredientes
                        </h3>
                        <span class="text-xs font-mono font-bold px-2.5 py-1 rounded-full {{ count($selectedIngredients) === 3 ? 'bg-emerald-100 text-[#17A085] border border-emerald-300' : 'bg-amber-100 text-[#F5A623] border border-amber-300' }}">
                            {{ count($selectedIngredients) }}/3 Seleccionados
                        </span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                        @foreach($availableIngredients as $ing)
                            @php
                                $isSelected = in_array($ing, $selectedIngredients);
                            @endphp
                            <button 
                                type="button"
                                wire:click="toggleIngredient('{{ $ing }}')"
                                class="p-3 rounded-2xl border text-center transition-all text-xs font-bold flex flex-col items-center justify-center gap-1 cursor-pointer {{ $isSelected ? 'border-[#C21818] bg-[#C21818] text-white shadow-sm' : 'border-[#EADDC9] bg-[#FFFDF8] text-[#524B40] hover:bg-white' }}"
                            >
                                <span>{{ $ing }}</span>
                                <span class="text-[10px] opacity-80">
                                    {{ $isSelected ? '✓ Elegido' : '+ Seleccionar' }}
                                </span>
                            </button>
                        @endforeach
                    </div>

                    <!-- Summary box -->
                    <div class="bg-white p-4 rounded-2xl border border-[#EADDC9] text-xs space-y-2 mt-4">
                        <div class="font-bold text-[#C21818] uppercase tracking-wider">Resumen de tu Pasta:</div>
                        <div class="grid grid-cols-2 gap-2 text-[#524B40]">
                            <div><strong class="text-[#1F1F1F]">Tamaño:</strong> {{ $size }}</div>
                            <div><strong class="text-[#1F1F1F]">Salsa:</strong> {{ $sauce }}</div>
                            <div><strong class="text-[#1F1F1F]">Proteína:</strong> {{ $protein }}</div>
                            <div><strong class="text-[#1F1F1F]">Ingredientes:</strong> {{ implode(', ', $selectedIngredients) ?: 'Ninguno' }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Navigation Controls -->
            <div class="flex items-center justify-between pt-6 mt-6 border-t border-[#EADDC9]">
                @if($currentStep > 1)
                    <button 
                        wire:click="previousStep"
                        class="px-4 py-2 rounded-xl text-xs font-bold text-[#524B40] bg-[#FFFDF8] border border-[#EADDC9] hover:bg-white transition-colors cursor-pointer"
                    >
                        ← Anterior
                    </button>
                @else
                    <div></div>
                @endif

                @if($currentStep < 4)
                    <button 
                        wire:click="nextStep"
                        class="diner-button-aqua px-6 py-2.5 rounded-xl text-xs uppercase tracking-wider cursor-pointer"
                    >
                        Siguiente →
                    </button>
                @else
                    <button 
                        wire:click="addPastaToCart"
                        class="diner-button-primary px-8 py-3 rounded-2xl text-xs uppercase tracking-wider flex items-center gap-2 cursor-pointer shadow-lg"
                    >
                        <span>Agregar Pasta a la Orden (${{ number_format($basePrice, 2) }})</span>
                        <span>🍝</span>
                    </button>
                @endif
            </div>

        </div>
    </div>
</div>
