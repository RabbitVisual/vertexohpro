<div x-data="{
         online: navigator.onLine,
         init() {
             window.addEventListener('online', () => this.online = true);
             window.addEventListener('offline', () => this.online = false);
         }
     }"
     x-show="!online"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="translate-y-full opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-y-0 opacity-100"
     x-transition:leave-end="translate-y-full opacity-0"
     class="fixed bottom-0 left-0 right-0 z-50 bg-slate-900/90 backdrop-blur text-white p-3 text-center shadow-lg border-t border-slate-700"
     style="display: none;">
    <div class="flex items-center justify-center gap-2 text-sm font-medium">
        <x-icon name="wifi-slash" class="w-4 h-4 text-red-400" />
        <span>Você está offline. Alterações serão sincronizadas quando a conexão retornar.</span>
    </div>
</div>
