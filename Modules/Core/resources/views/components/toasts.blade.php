<div x-data="{
        notifications: [],
        add(e) {
            this.notifications.push({
                id: Date.now(),
                message: e.detail.message,
                type: e.detail.type || 'info'
            });
        },
        remove(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }"
    @notify.window="add($event)"
    x-init="
        @if (session()->has('version_updates'))
            setTimeout(() => {
                $dispatch('notify', { message: 'Atualizações Disponíveis! Alguns dos seus materiais comprados foram atualizados.', type: 'info' })
            }, 500);
        @endif
        @if (session('success'))
            setTimeout(() => { $dispatch('notify', { message: '{{ session('success') }}', type: 'success' }) }, 100);
        @endif
        @if (session('error'))
            setTimeout(() => { $dispatch('notify', { message: '{{ session('error') }}', type: 'error' }) }, 100);
        @endif
    "
    class="fixed inset-0 flex flex-col items-end justify-start px-4 py-6 pointer-events-none sm:p-6 z-[10000] mt-16"
>
    <template x-for="notification in notifications" :key="notification.id">
        <div class="w-full flex flex-col items-center space-y-4 sm:items-end transform transition-all duration-300"
             x-transition:enter="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="translate-x-full opacity-0">

             <div class="max-w-sm w-full shadow-lg rounded-lg pointer-events-auto border-l-4 overflow-hidden mb-3 bg-white dark:bg-slate-900"
                  :class="{
                      'bg-emerald-500/10 border-emerald-500 text-emerald-600 dark:text-emerald-400': notification.type === 'success',
                      'bg-red-500/10 border-red-500 text-red-600 dark:text-red-400': notification.type === 'error',
                      'bg-amber-500/10 border-amber-500 text-amber-600 dark:text-amber-400': notification.type === 'warning',
                      'bg-indigo-500/10 border-indigo-500 text-indigo-600 dark:text-indigo-400': notification.type === 'info'
                  }"
                  x-data="{ show: true }"
                  x-show="show"
                  x-init="setTimeout(() => { show = false; setTimeout(() => remove(notification.id), 300) }, 5000)"
             >
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fa-duotone fa-lg"
                               :class="{
                                   'fa-check-circle': notification.type === 'success',
                                   'fa-circle-exclamation': notification.type === 'error',
                                   'fa-triangle-exclamation': notification.type === 'warning',
                                   'fa-circle-info': notification.type === 'info'
                               }"
                            ></i>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium" x-text="notification.message"></p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button @click="show = false; setTimeout(() => remove(notification.id), 300)" class="inline-flex text-slate-400 hover:text-slate-500 focus:outline-none">
                                <span class="sr-only">Close</span>
                                <i class="fa-duotone fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </template>
</div>
