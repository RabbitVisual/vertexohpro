<div class="p-4 bg-slate-900 rounded-lg min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white flex items-center">
            <i class="fa-duotone fa-clipboard-user mr-3 text-indigo-500"></i>
            Chamada Rápida - {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
        </h2>
    </div>

    <div class="space-y-4">
        @foreach($students as $student)
            <div
                x-data="{ showObs: false }"
                class="bg-slate-800 p-4 rounded-xl border border-slate-700 shadow-lg transition-all duration-300 hover:border-slate-600"
                wire:key="student-{{ $student->id }}"
            >
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center justify-between w-full md:w-auto">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-full bg-slate-700 flex items-center justify-center text-slate-300 font-bold">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <span class="text-lg font-medium text-slate-200">{{ $student->name }}</span>
                        </div>

                        <button
                            @click="showObs = !showObs"
                            class="md:hidden text-slate-400 hover:text-indigo-400 focus:outline-none transition-colors p-2"
                            title="Observação"
                        >
                            <i class="fa-duotone fa-memo-pad text-xl"></i>
                        </button>
                    </div>

                    <div class="flex items-center justify-center space-x-2 w-full md:w-auto">
                         <!-- Observation Toggle (Desktop) -->
                        <button
                            @click="showObs = !showObs"
                            class="hidden md:block text-slate-400 hover:text-indigo-400 focus:outline-none transition-colors p-2 mr-2"
                            title="Observação"
                        >
                            <i class="fa-duotone fa-memo-pad text-xl"></i>
                        </button>

                        <!-- Present (Green) -->
                        <button
                            x-on:click="window.navigator.vibrate(50); $wire.setStatus({{ $student->id }}, 'present')"
                            class="flex-1 md:flex-none px-3 py-2 md:px-4 md:py-3 rounded-lg font-bold transition-all transform active:scale-95 text-sm md:text-base flex items-center justify-center
                            {{ ($attendanceData[$student->id] ?? '') === 'present'
                                ? 'bg-emerald-600 text-white ring-2 ring-emerald-400 shadow-emerald-500/20 shadow-lg'
                                : 'bg-slate-700 text-slate-400 hover:bg-emerald-900/30 hover:text-emerald-200' }}">
                            <i class="fa-duotone fa-check mr-1.5"></i> Pres
                        </button>

                        <!-- Absent (Red) -->
                        <button
                            x-on:click="window.navigator.vibrate(50); $wire.setStatus({{ $student->id }}, 'absent')"
                            class="flex-1 md:flex-none px-3 py-2 md:px-4 md:py-3 rounded-lg font-bold transition-all transform active:scale-95 text-sm md:text-base flex items-center justify-center
                            {{ ($attendanceData[$student->id] ?? '') === 'absent'
                                ? 'bg-red-600 text-white ring-2 ring-red-400 shadow-red-500/20 shadow-lg'
                                : 'bg-slate-700 text-slate-400 hover:bg-red-900/30 hover:text-red-200' }}">
                            <i class="fa-duotone fa-times mr-1.5"></i> Falta
                        </button>

                        <!-- Justified (Yellow) -->
                        <button
                            x-on:click="window.navigator.vibrate(50); $wire.setStatus({{ $student->id }}, 'justified')"
                            class="flex-1 md:flex-none px-3 py-2 md:px-4 md:py-3 rounded-lg font-bold transition-all transform active:scale-95 text-sm md:text-base flex items-center justify-center
                            {{ ($attendanceData[$student->id] ?? '') === 'justified'
                                ? 'bg-yellow-500 text-black ring-2 ring-yellow-300 shadow-yellow-500/20 shadow-lg'
                                : 'bg-slate-700 text-slate-400 hover:bg-yellow-900/30 hover:text-yellow-200' }}">
                            <i class="fa-duotone fa-file-medical mr-1.5"></i> Just
                        </button>
                    </div>
                </div>

                <!-- Observation Area -->
                <div
                    x-show="showObs"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="mt-4 pl-0 md:pl-14"
                    style="display: none;"
                >
                    <textarea
                        wire:model.blur="observations.{{ $student->id }}"
                        placeholder="Observação individual sobre o aluno (comportamento, material, etc)..."
                        class="w-full bg-slate-900/50 text-slate-200 border border-slate-600 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-500 resize-y min-h-[80px]"
                    ></textarea>
                </div>
            </div>
        @endforeach
    </div>
</div>
