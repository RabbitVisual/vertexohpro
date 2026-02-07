<x-teacherpanel::layouts.master :title="'Painel do Professor'">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6 text-slate-800 dark:text-slate-100">Painel do Professor</h1>

        <div x-data="{
                 init() {
                     // Check if Sortable is available globally
                     if (window.Sortable) {
                         new Sortable(this.$refs.widgetsList, {
                             animation: 150,
                             ghostClass: 'opacity-50',
                             handle: '.drag-handle', // Optional: restrict drag to handle if needed, or entire card
                             onEnd: (evt) => {
                                 const newOrder = Array.from(evt.to.children)
                                     .map(el => el.getAttribute('data-widget'))
                                     .filter(w => w);
                                 this.saveOrder(newOrder);
                             }
                         });
                     } else {
                         console.warn('SortableJS not found');
                     }
                 },
                 saveOrder(order) {
                     fetch('{{ route('teacherpanel.update_settings') }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                             'Accept': 'application/json'
                         },
                         body: JSON.stringify({
                             widget_order: order
                         })
                     })
                     .then(response => response.json())
                     .then(data => {
                         console.log('Ordem salva:', data);
                     })
                     .catch(error => {
                         console.error('Erro ao salvar ordem:', error);
                     });
                 }
             }">

            <div x-ref="widgetsList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($widgets as $widget)
                    <div data-widget="{{ $widget }}" class="h-full transition-transform duration-200 hover:shadow-lg rounded-lg cursor-move">
                        @if($widget == 'notas-rapidas')
                            <x-teacherpanel::widgets.notas-rapidas :notes="$notes ?? ''" />
                        @else
                            <x-dynamic-component :component="'teacherpanel::widgets.' . $widget" />
                        @endif
                    </div>
                @endforeach
<x-teacherpanel::layouts.master title="Painel do Professor">
    <div x-data="{
        init() {
            // SortableJS initialization
            const el = document.getElementById('dashboard-grid');
            if (el && window.Sortable) {
                Sortable.create(el, {
                    animation: 150,
                    handle: '.drag-handle',
                    ghostClass: 'bg-indigo-50/50',
                    chosenClass: 'scale-105',
                    dragClass: 'opacity-50',
                    delay: 100,
                    delayOnTouchOnly: true,
                    store: {
                        get: function (sortable) {
                            const order = localStorage.getItem(sortable.options.group.name);
                            return order ? order.split('|') : [];
                        },
                        set: function (sortable) {
                            const order = sortable.toArray();
                            localStorage.setItem(sortable.options.group.name, order.join('|'));
                        }
                    },
                    group: 'dashboard-widgets'
                });
            }
        }
    }" class="p-6 space-y-6">

        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-display font-bold text-slate-900 dark:text-white">Olá, Professor(a)!</h1>
                <p class="text-slate-500 dark:text-slate-400">Aqui está o resumo das suas atividades.</p>
            </div>
            <div class="flex gap-2">
                <x-button variant="secondary" icon="calendar">Agenda</x-button>
                <x-button icon="plus">Nova Aula</x-button>
            </div>
        </header>

        <!-- Dashboard Grid -->
        <div id="dashboard-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Widget 1: Sticky Notes -->
            <div class="h-full relative group transition-transform duration-200" data-id="sticky-notes">
                <div class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-opacity cursor-grab drag-handle p-1 text-slate-400 hover:text-slate-600">
                    <i class="fa-duotone fa-grip-vertical"></i>
                </div>
                @include('teacherpanel::widgets.sticky-notes')
            </div>

            <!-- Widget 2: Support Ticket -->
            <div class="h-full relative group transition-transform duration-200" data-id="support-ticket">
                <div class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-opacity cursor-grab drag-handle p-1 text-slate-400 hover:text-slate-600">
                    <i class="fa-duotone fa-grip-vertical"></i>
                </div>
                @include('teacherpanel::widgets.support-ticket')
            </div>

            <!-- Widget 3: Recent Classes -->
            <div class="h-full relative group transition-transform duration-200" data-id="recent-classes">
                <div class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-opacity cursor-grab drag-handle p-1 text-slate-400 hover:text-slate-600">
                    <i class="fa-duotone fa-grip-vertical"></i>
                </div>
                <x-card title="Aulas Recentes" class="h-full">
                    <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-slate-800 dark:text-slate-200">Matemática - 6A</p>
                                <p class="text-xs text-slate-500">Hoje, 08:00</p>
                            </div>
                            <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-600 text-xs font-bold">Concluída</span>
                        </li>
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-slate-800 dark:text-slate-200">Ciências - 7B</p>
                                <p class="text-xs text-slate-500">Ontem, 10:00</p>
                            </div>
                            <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-600 text-xs font-bold">Concluída</span>
                        </li>
                    </ul>
                </x-card>
            </div>

            <!-- Widget 4: Quick Actions -->
            <div class="h-full relative group transition-transform duration-200" data-id="quick-actions">
                <div class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-opacity cursor-grab drag-handle p-1 text-slate-400 hover:text-slate-600">
                    <i class="fa-duotone fa-grip-vertical"></i>
                </div>
                <x-card title="Acesso Rápido" class="h-full">
                     <div class="grid grid-cols-2 gap-4">
                        <button class="flex flex-col items-center justify-center p-4 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-600 transition-colors">
                            <i class="fa-duotone fa-2xl fa-user-plus mb-2"></i>
                            <span class="text-sm font-medium">Matricular</span>
                        </button>
                        <button class="flex flex-col items-center justify-center p-4 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-600 transition-colors">
                            <i class="fa-duotone fa-2xl fa-file-chart-column mb-2"></i>
                            <span class="text-sm font-medium">Relatórios</span>
                        </button>
                     </div>
                </x-card>
            </div>

        </div>
    </div>

    <x-teacherpanel::notifications-poller />
</x-teacherpanel::layouts.master>

<x-teacherpanel::welcome-tour />
</x-teacherpanel::layouts.master>

<x-teacherpanel::notifications-poller />
