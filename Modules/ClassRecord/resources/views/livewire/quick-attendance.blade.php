<div class="p-4 bg-slate-900 rounded-lg">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-white">Chamada Rápida - {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h2>
    </div>

    <div class="space-y-4">
        @foreach($students as $student)
            <div class="bg-slate-800 p-4 rounded-lg flex flex-col sm:flex-row items-center justify-between border border-slate-700" wire:key="student-{{ $student->id }}">
                <div class="mb-2 sm:mb-0">
                    <span class="text-lg font-medium text-slate-200">{{ $student->name }}</span>
                </div>

                <div class="flex space-x-2">
                    <!-- Present (Green) -->
                    <button
                        wire:click="setStatus({{ $student->id }}, 'present')"
                        class="px-4 py-3 rounded-lg font-bold transition-colors w-24
                        {{ ($attendanceData[$student->id] ?? '') === 'present' ? 'bg-emerald-500 text-white ring-2 ring-emerald-300' : 'bg-slate-700 text-slate-400 hover:bg-emerald-900/50' }}">
                        <i class="fa-duotone fa-check mr-1"></i> Pres
                    </button>

                    <!-- Absent (Red) -->
                    <button
                        wire:click="setStatus({{ $student->id }}, 'absent')"
                        class="px-4 py-3 rounded-lg font-bold transition-colors w-24
                        {{ ($attendanceData[$student->id] ?? '') === 'absent' ? 'bg-red-500 text-white ring-2 ring-red-300' : 'bg-slate-700 text-slate-400 hover:bg-red-900/50' }}">
                        <i class="fa-duotone fa-times mr-1"></i> Falta
                    </button>

                    <!-- Justified (Yellow) -->
                    <button
                        wire:click="setStatus({{ $student->id }}, 'justified')"
                        class="px-4 py-3 rounded-lg font-bold transition-colors w-24
                        {{ ($attendanceData[$student->id] ?? '') === 'justified' ? 'bg-yellow-500 text-black ring-2 ring-yellow-300' : 'bg-slate-700 text-slate-400 hover:bg-yellow-900/50' }}">
                        <i class="fa-duotone fa-file-medical mr-1"></i> Just
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
