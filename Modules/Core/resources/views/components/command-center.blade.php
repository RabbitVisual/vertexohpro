<div x-data="{
        open: false,
        search: '',
        activeIndex: 0,
        items: [],
        allItems: [
            @foreach(config('icons.modules', []) as $module => $config)
                { label: '{{ $config['label'] ?? ucfirst($module) }}', url: '{{ Route::has($module . '.index') ? route($module . '.index') : '#' }}', icon: '{{ $config['icon'] ?? 'circle-question' }}' },
            @endforeach
        ],
        get filteredItems() {
            if (this.search === '') return [];
            return this.allItems.filter(i => i.label.toLowerCase().includes(this.search.toLowerCase()));
        },
        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => this.$refs.searchInput.focus());
                this.search = '';
                this.activeIndex = 0;
            }
        },
        goToActive() {
            if (this.filteredItems.length > 0) {
                window.location.href = this.filteredItems[this.activeIndex].url;
            }
        }
    }"
    @keydown.window.prevent.cmd.k="toggle()"
    @keydown.window.prevent.ctrl.k="toggle()"
    class="relative z-50">

    <!-- Trigger Button (Visible in Sidebar/Header) -->
    <button @click="toggle()" class="flex items-center px-4 py-2 text-sm text-slate-400 hover:text-white transition-colors">
        <x-icon name="search" class="mr-3 h-5 w-5" />
        <span class="hidden md:inline">Pesquisar... (Cmd+K)</span>
    </button>

    <!-- Modal Overlay -->
    <div x-show="open"
         x-transition.opacity
         @click.outside="open = false"
         class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm flex items-start justify-center pt-24"
         style="display: none;">

        <!-- Modal Content -->
        <div class="bg-white dark:bg-slate-800 w-full max-w-lg rounded-xl shadow-2xl overflow-hidden border border-slate-700"
             @keydown.arrow-down.prevent="activeIndex = (activeIndex + 1) % filteredItems.length"
             @keydown.arrow-up.prevent="activeIndex = (activeIndex - 1 + filteredItems.length) % filteredItems.length"
             @keydown.enter.prevent="goToActive()"
             @keydown.escape.prevent="open = false">

            <div class="border-b border-slate-700 p-4 flex items-center">
                <x-icon name="search" class="text-slate-400 mr-3 h-5 w-5" />
                <input x-ref="searchInput"
                       x-model="search"
                       type="text"
                       placeholder="O que você procura?"
                       class="w-full bg-transparent border-none focus:ring-0 text-slate-900 dark:text-white placeholder-slate-500 text-lg">
                <span class="text-xs text-slate-500 border border-slate-600 rounded px-1.5 py-0.5">ESC</span>
            </div>

            <div class="max-h-96 overflow-y-auto p-2" x-show="filteredItems.length > 0">
                <template x-for="(item, index) in filteredItems" :key="index">
                    <a :href="item.url"
                       class="flex items-center px-4 py-3 rounded-lg group transition-colors"
                       :class="{ 'bg-indigo-600 text-white': index === activeIndex, 'text-slate-700 dark:text-slate-300 hover:bg-slate-700/50': index !== activeIndex }"
                       @mouseenter="activeIndex = index">
                        <i :class="'fa-duotone fa-' + item.icon" class="mr-3 h-5 w-5 opacity-70"></i>
                        <span x-text="item.label" class="font-medium"></span>
                        <span class="ml-auto text-xs opacity-50" x-show="index === activeIndex">Enter</span>
                    </a>
                </template>
            </div>

            <div class="p-4 text-center text-slate-500 text-sm" x-show="search === ''">
                Digite para buscar módulos...
            </div>

            <div class="p-4 text-center text-slate-500 text-sm" x-show="search !== '' && filteredItems.length === 0">
                Nenhum resultado encontrado.
            </div>
        </div>
    </div>
</div>
