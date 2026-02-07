<div class="bg-white dark:bg-slate-900 rounded-lg shadow p-4 h-full border border-slate-200 dark:border-slate-800"
     x-data="bnccWidget()">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-poppins font-semibold text-lg text-slate-800 dark:text-slate-100">
            Atalhos BNCC
        </h3>
        <x-icon name="book-bookmark" class="w-5 h-5 text-blue-500" />
    </div>

    <div class="relative mb-4">
        <input type="text" placeholder="Buscar habilidade (ex: EF06MA01)..."
               x-model.debounce.500ms="query"
               @input="search()"
               class="w-full text-sm rounded-md border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2 pl-9" />
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <x-icon name="magnifying-glass" class="w-4 h-4 text-slate-400" />
        </div>
        <div x-show="loading" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" style="display: none;">
            <x-icon name="spinner" class="w-4 h-4 text-indigo-500 animate-spin" />
        </div>
    </div>

    <div x-show="results.length > 0" class="flex flex-col gap-2 max-h-64 overflow-y-auto custom-scrollbar" style="display: none;">
        <template x-for="skill in results" :key="skill.code">
            <div class="p-2 bg-slate-50 dark:bg-slate-800 rounded border border-slate-200 dark:border-slate-700 group hover:bg-white dark:hover:bg-slate-700 transition-colors">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-bold text-xs text-indigo-600 dark:text-indigo-400" x-text="skill.code"></span>
                    <button @click="copyToClipboard(skill.description)"
                            class="text-slate-400 hover:text-indigo-500 transition-colors p-1 rounded hover:bg-slate-200 dark:hover:bg-slate-600"
                            title="Copiar Descrição">
                        <x-icon name="copy" class="w-3 h-3" />
                    </button>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-300 line-clamp-2" x-text="skill.description" :title="skill.description"></p>
            </div>
        </template>
    </div>

    <div x-show="!loading && query.length >= 3 && results.length === 0" class="text-center text-xs text-slate-500 mt-4" style="display: none;">
        Nenhuma habilidade encontrada.
    </div>

    <!-- Default pills if no search -->
    <div x-show="query.length === 0" class="mt-4 flex flex-wrap gap-2">
         <button @click="query = 'EF06MA01'; search()" class="px-2 py-1 bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 text-xs rounded-full cursor-pointer hover:bg-indigo-200 transition-colors">EF06MA01</button>
         <button @click="query = 'EF07MA02'; search()" class="px-2 py-1 bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 text-xs rounded-full cursor-pointer hover:bg-indigo-200 transition-colors">EF07MA02</button>
         <button @click="query = 'EF08MA03'; search()" class="px-2 py-1 bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 text-xs rounded-full cursor-pointer hover:bg-indigo-200 transition-colors">EF08MA03</button>
    </div>

    <script>
        function bnccWidget() {
            return {
                query: '',
                results: [],
                loading: false,

                search() {
                    if (this.query.length < 3) {
                        this.results = [];
                        return;
                    }

                    this.loading = true;
                    fetch("{{ route('teacherpanel.widgets.bncc') }}?q=" + encodeURIComponent(this.query))
                        .then(res => res.json())
                        .then(data => {
                            this.results = data;
                            this.loading = false;
                        })
                        .catch(err => {
                            console.error(err);
                            this.loading = false;
                        });
                },

                copyToClipboard(text) {
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(text).then(() => {
                            // Simple alert for now, could be a toast
                            alert('Descrição copiada para a área de transferência!');
                        }).catch(err => {
                             console.error('Failed to copy: ', err);
                             alert('Erro ao copiar.');
                        });
                    } else {
                        // Fallback
                        const textarea = document.createElement('textarea');
                        textarea.value = text;
                        document.body.appendChild(textarea);
                        textarea.select();
                        try {
                            document.execCommand('copy');
                            alert('Descrição copiada para a área de transferência!');
                        } catch (err) {
                            console.error('Fallback copy failed', err);
                             alert('Erro ao copiar.');
                        }
                        document.body.removeChild(textarea);
                    }
                }
            }
        }
    </script>
</div>
