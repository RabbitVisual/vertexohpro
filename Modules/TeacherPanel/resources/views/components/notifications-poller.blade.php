<div x-data="notificationPoller()"
     x-init="init()"
     class="fixed bottom-4 right-4 z-50 flex flex-col gap-2 pointer-events-none w-80">

    <template x-for="note in queue" :key="note.id">
        <div class="pointer-events-auto bg-white dark:bg-slate-800 border-l-4 shadow-lg rounded-r p-4 flex items-start gap-3 transform transition-all duration-500"
             :class="{
                'border-emerald-500': note.type === 'marketplace',
                'border-blue-500': note.type === 'support'
             }"
             x-transition:enter="translate-y-2 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="translate-x-full opacity-0">

            <div class="flex-shrink-0 pt-0.5">
                <template x-if="note.type === 'marketplace'">
                    <x-icon name="sack-dollar" class="w-6 h-6 text-emerald-500" />
                </template>
                <template x-if="note.type === 'support'">
                    <x-icon name="headset" class="w-6 h-6 text-blue-500" />
                </template>
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-900 dark:text-slate-100 truncate" x-text="note.title"></p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1" x-text="note.message"></p>
            </div>

            <button @click="remove(note)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 ml-2">
                <x-icon name="xmark" class="w-4 h-4" />
            </button>
        </div>
    </template>

    <script>
        function notificationPoller() {
            return {
                lastCheck: '{{ now()->subSeconds(10)->toDateTimeString() }}',
                queue: [],

                init() {
                    // Poll every 10 seconds
                    setInterval(() => {
                        this.check();
                    }, 10000);
                },

                check() {
                    fetch("{{ route('teacherpanel.notifications.check') }}?last_check=" + encodeURIComponent(this.lastCheck))
                        .then(res => res.json())
                        .then(data => {
                            if (data.notifications && data.notifications.length > 0) {
                                // Add to queue
                                data.notifications.forEach(note => {
                                    this.push(note);
                                });
                            }
                            // Update last check time
                            this.lastCheck = data.timestamp;
                        })
                        .catch(err => console.error('Notification poll failed', err));
                },

                push(note) {
                    this.queue.push(note);
                    // Auto dismiss after 5 seconds
                    setTimeout(() => {
                        this.remove(note);
                    }, 5000);
                },

                remove(note) {
                    // Find index by ID because object reference might differ?
                    // No, push(note) uses same ref. But let's be safe.
                    const index = this.queue.indexOf(note);
                    if (index > -1) {
                        this.queue.splice(index, 1);
                    }
                }
            }
        }
    </script>
</div>
