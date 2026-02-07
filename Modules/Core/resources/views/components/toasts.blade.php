<div class="fixed bottom-4 right-4 z-50 flex flex-col space-y-2 pointer-events-none">

    {{-- Success --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="pointer-events-auto bg-emerald-600 text-white px-6 py-4 rounded shadow-lg flex items-center max-w-sm">
            <x-icon name="check-circle" class="mr-3 h-6 w-6" />
            <div>
                <p class="font-bold">Sucesso!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="ml-4 text-white hover:text-gray-200">
                <x-icon name="times" class="h-4 w-4" />
            </button>
        </div>
    @endif

    {{-- Error (Persistent) --}}
    @if (session()->has('error') || $errors->any())
        <div x-data="{ show: true }" x-show="show"
             class="pointer-events-auto bg-red-600 text-white px-6 py-4 rounded shadow-lg flex items-center max-w-sm">
            <x-icon name="exclamation-triangle" class="mr-3 h-6 w-6" />
            <div>
                <p class="font-bold">Atenção!</p>
                @if(session()->has('error'))
                    <p class="text-sm">{{ session('error') }}</p>
                @else
                    <ul class="text-sm list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <button @click="show = false" class="ml-4 text-white hover:text-gray-200">
                <x-icon name="times" class="h-4 w-4" />
            </button>
        </div>
    @endif

    {{-- Info / Updates (Generic) --}}
    @if (session()->has('version_updates'))
        <div x-data="{ show: true }" x-show="show"
             class="pointer-events-auto bg-indigo-600 text-white px-6 py-4 rounded shadow-lg flex items-center max-w-sm">
            <x-icon name="cloud-download" class="mr-3 h-6 w-6" />
            <div>
                <p class="font-bold">Atualizações Disponíveis!</p>
                <p class="text-sm">Alguns dos seus materiais comprados foram atualizados.</p>
            </div>
            <button @click="show = false" class="ml-4 text-white hover:text-gray-200">
                <x-icon name="times" class="h-4 w-4" />
            </button>
        </div>
    @endif
</div>
