<div
    x-data="{
        notifications: [],
        add(e) {
            const id = Date.now();
            this.notifications.push({
                id: id,
                message: e.detail.message,
                type: e.detail.type || 'success',
                show: true
            });
            setTimeout(() => this.remove(id), 4000);
        },
        remove(id) {
            const index = this.notifications.findIndex(n => n.id === id);
            if (index > -1) {
                this.notifications[index].show = false;
                setTimeout(() => {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                }, 400);
            }
        }
    }"
    @notify.window="add($event)"
    class="fixed bottom-4 right-4 z-[9999] flex flex-col gap-2 w-full max-w-sm pointer-events-none"
    role="status"
    aria-live="polite"
>
    <template x-for="notification in notifications" :key="notification.id">
        <div
            x-show="notification.show"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 flex bg-white dark:bg-slate-800 border-l-4"
            :class="{
                'border-emerald-500': notification.type === 'success',
                'border-red-500': notification.type === 'error',
                'border-blue-500': notification.type === 'info'
            }"
        >
            <div class="p-4 flex items-start w-full">
                <div class="flex-shrink-0 mr-3">
                    <template x-if="notification.type === 'success'">
                        <i class="fa-duotone fa-check-circle text-emerald-500 text-xl"></i>
                    </template>
                    <template x-if="notification.type === 'error'">
                        <i class="fa-duotone fa-circle-xmark text-red-500 text-xl"></i>
                    </template>
                    <template x-if="notification.type === 'info'">
                        <i class="fa-duotone fa-circle-info text-blue-500 text-xl"></i>
                    </template>
                </div>
                <div class="w-0 flex-1 pt-0.5">
                    <p x-text="notification.message" class="text-sm font-medium text-gray-900 dark:text-gray-100"></p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="remove(notification.id)" class="rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">Fechar</span>
                        <i class="fa-solid fa-xmark h-4 w-4"></i>
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
