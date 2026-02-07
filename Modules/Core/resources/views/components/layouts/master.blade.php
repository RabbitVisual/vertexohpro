<x-layouts.app :title="$title ?? 'Vertex Oh Pro'">
    <div class="flex h-screen bg-slate-50 overflow-hidden">
        <!-- Sidebar -->
        <x-core::layouts.sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            <header class="bg-white shadow-sm h-16 flex items-center px-6 flex-shrink-0">
                <h1 class="text-xl font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layouts.app>
    <x-core::toasts />
