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
                        <x-dynamic-component :component="'teacherpanel::widgets.' . $widget" />
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-teacherpanel::layouts.master>
