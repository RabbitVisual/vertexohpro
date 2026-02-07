@props([])

<div x-data="{
        open: false,
        query: '',
        results: [],
        selectedIndex: 0,
        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => this.$refs.searchInput.focus());
            } else {
                this.query = '';
                this.results = [];
            }
        },
        search() {
            if (this.query.length < 2) {
                this.results = [];
                return;
            }
            fetch('{{ route('command-center.search') }}?query=' + this.query)
                .then(res => res.json())
                .then(data => {
                    this.results = data;
                    this.selectedIndex = 0;
                });
        },
        selectResult() {
            if (this.results.length > 0 && this.results[this.selectedIndex]) {
                window.location.href = this.results[this.selectedIndex].url;
            }
        },
        navigate(direction) {
            if (direction === 'down') {
                this.selectedIndex = (this.selectedIndex + 1) % this.results.length;
            } else if (direction === 'up') {
                this.selectedIndex = (this.selectedIndex - 1 + this.results.length) % this.results.length;
            }
        }
    }"
    @keydown.window.cmd.k.prevent="toggle()"
    @keydown.window.ctrl.k.prevent="toggle()"
    @keydown.escape.window="open = false"
    x-show="open"
    class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 md:p-20"
    style="display: none;"
>
    <!-- Overlay -->
    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm" @click="open = false"></div>

    <!-- Panel -->
    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="mx-auto max-w-xl transform divide-y divide-gray-100 dark:divide-gray-800 overflow-hidden rounded-xl bg-white dark:bg-gray-900 shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
        <div class="relative">
            <x-icon name="search" class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-gray-400 dark:text-gray-500" />
            <input x-ref="searchInput" type="text" class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:ring-0 sm:text-sm" placeholder="Search students, classes, plans..." @input.debounce.300ms="search()" x-model="query" @keydown.down.prevent="navigate('down')" @keydown.up.prevent="navigate('up')" @keydown.enter.prevent="selectResult()">
        </div>

        <ul x-show="results.length > 0" class="max-h-96 scroll-py-3 overflow-y-auto p-3" id="options" role="listbox">
            <template x-for="(result, index) in results" :key="index">
                <li class="group flex cursor-default select-none rounded-xl p-3" :class="{ 'bg-gray-100 dark:bg-gray-800': selectedIndex === index }" @click="selectedIndex = index; selectResult()" @mouseenter="selectedIndex = index">
                    <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-indigo-500/10 dark:bg-indigo-500/20">
                        <x-icon name="user" x-show="result.type === 'student'" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
                        <x-icon name="users" x-show="result.type === 'class'" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
                        <x-icon name="file-text" x-show="result.type === 'plan'" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <div class="ml-4 flex-auto">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="result.title"></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400" x-text="result.subtitle"></p>
                    </div>
                </li>
            </template>
        </ul>

        <div x-show="query !== '' && results.length === 0" class="py-14 px-6 text-center sm:px-14">
            <x-icon name="search" class="mx-auto h-6 w-6 text-gray-400 dark:text-gray-500" />
            <p class="mt-4 text-sm text-gray-900 dark:text-gray-100">No results found.</p>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800/50 px-4 py-2.5 text-xs text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-gray-800 flex justify-between">
            <span>Type to search...</span>
            <div class="flex gap-2">
                 <span><kbd class="font-sans font-semibold">↑↓</kbd> to navigate</span>
                 <span><kbd class="font-sans font-semibold">↵</kbd> to select</span>
                 <span><kbd class="font-sans font-semibold">ESC</kbd> to close</span>
            </div>
        </div>
    </div>
</div>
