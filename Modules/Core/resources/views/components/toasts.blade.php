@if (session()->has('version_updates'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)"
         class="fixed bottom-4 right-4 bg-indigo-600 text-white px-6 py-4 rounded shadow-lg flex items-center z-50">
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
