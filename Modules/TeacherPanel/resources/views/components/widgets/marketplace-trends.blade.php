<div class="bg-white dark:bg-slate-900 rounded-lg shadow p-4 h-full border border-slate-200 dark:border-slate-800"
     x-data="{
         trends: [],
         loading: true,
         init() {
             fetch('{{ route('teacherpanel.widgets.marketplace_trends') }}')
                 .then(res => res.json())
                 .then(data => {
                     this.trends = data;
                     this.loading = false;
                 })
                 .catch(err => {
                     console.error('Failed to load marketplace trends', err);
                     this.loading = false;
                 });
         }
     }">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-poppins font-semibold text-lg text-slate-800 dark:text-slate-100">
            Tendências da Loja
        </h3>
        <x-icon name="fire" class="w-5 h-5 text-red-500" />
    </div>

    <div x-show="loading" class="flex justify-center items-center h-32">
        <x-icon name="spinner" class="w-6 h-6 animate-spin text-indigo-500" />
    </div>

    <ul x-show="!loading" class="space-y-2">
        <template x-for="(item, index) in trends" :key="index">
            <li class="flex items-center justify-between p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded transition-colors group cursor-pointer">
                <div class="flex items-center gap-3 overflow-hidden">
                    <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-xs font-bold rounded-full text-slate-500 group-hover:text-indigo-500 group-hover:bg-indigo-50 transition-colors" x-text="index + 1"></span>
                    <span class="text-sm text-slate-700 dark:text-slate-300 truncate" x-text="item.title"></span>
                </div>
                <div class="flex items-center gap-1 text-xs text-slate-400 group-hover:text-slate-600 transition-colors">
                    <x-icon name="download" class="w-3 h-3" />
                    <span x-text="item.downloads_count"></span>
                </div>
            </li>
        </template>
    </ul>
</div>
