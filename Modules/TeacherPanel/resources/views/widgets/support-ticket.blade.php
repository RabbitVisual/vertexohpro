<x-card title="Central de Tickets" class="h-full">
    <div x-data="{
        subject: '',
        message: '',
        loading: false,
        submit() {
            if (!this.subject || !this.message) return;
            this.loading = true;

            fetch('{{ route('support.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ subject: this.subject, message: this.message })
            })
            .then(res => res.json())
            .then(data => {
                this.loading = false;
                if (data.message) {
                    window.dispatchEvent(new CustomEvent('notify', { detail: { message: data.message, type: 'success' } }));
                    this.subject = '';
                    this.message = '';
                }
            })
            .catch(err => {
                this.loading = false;
                window.dispatchEvent(new CustomEvent('notify', { detail: { message: 'Erro ao enviar ticket', type: 'error' } }));
                console.error(err);
            });
        }
    }" class="space-y-4">

        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Assunto</label>
            <input type="text" x-model="subject" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Mensagem</label>
            <textarea x-model="message" rows="3" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-slate-800 dark:border-slate-700 dark:text-white"></textarea>
        </div>

        <div class="flex justify-end">
            <x-button @click="submit" ::loading="loading" icon="paper-plane">Enviar Ticket</x-button>
        </div>
    </div>
</x-card>
