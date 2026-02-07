<x-teacherpanel::layouts.master :title="'Painel do Professor'">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6 text-slate-800 dark:text-slate-100">Painel do Professor</h1>

        <div x-data="teacherPanel()"
             class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
             @dragover.prevent="dragOver($event)">

            @foreach($widgets as $widget)
                <div draggable="true"
                     data-widget="{{ $widget }}"
                     @dragstart="dragStart($event)"
                     @dragend="dragEnd($event)"
                     class="cursor-move h-full transition-transform duration-200 hover:shadow-lg rounded-lg">

                    <x-dynamic-component :component="'teacherpanel::widgets.' . $widget" />

                </div>
            @endforeach

        </div>
    </div>

    <script>
        function teacherPanel() {
            return {
                draggingEl: null,

                dragStart(e) {
                    this.draggingEl = e.target.closest('[draggable="true"]');
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/plain', JSON.stringify(this.draggingEl.dataset.widget));
                },

                dragOver(e) {
                    const target = e.target.closest('[draggable="true"]');
                    if (target && target !== this.draggingEl) {
                        const container = this.$el;
                        const children = Array.from(container.children);
                        const curIndex = children.indexOf(this.draggingEl);
                        const targetIndex = children.indexOf(target);

                        if (curIndex < targetIndex) {
                             container.insertBefore(this.draggingEl, target.nextSibling);
                        } else {
                             container.insertBefore(this.draggingEl, target);
                        }
                    }
                },

                dragEnd(e) {
                    this.draggingEl = null;

                    const newOrder = Array.from(this.$el.children)
                        .map(el => el.getAttribute('data-widget'))
                        .filter(w => w);

                    this.saveOrder(newOrder);
                },

                saveOrder(order) {
                    fetch("{{ route('teacherpanel.update_settings') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
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
            }
        }
    </script>
</x-teacherpanel::layouts.master>
