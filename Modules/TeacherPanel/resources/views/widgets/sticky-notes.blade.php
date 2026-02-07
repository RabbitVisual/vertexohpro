<x-card title="Lembretes Rápidos" class="h-full bg-yellow-50 dark:bg-yellow-900/10 border-yellow-200 dark:border-yellow-700">
    <div x-data="{
        notes: JSON.parse(localStorage.getItem('sticky_notes') || '[]'),
        newNote: '',
        add() {
            if (!this.newNote.trim()) return;
            this.notes.unshift({ id: Date.now(), text: this.newNote, done: false });
            this.newNote = '';
            this.save();
        },
        remove(id) {
            this.notes = this.notes.filter(n => n.id !== id);
            this.save();
        },
        toggle(id) {
            const note = this.notes.find(n => n.id === id);
            if (note) {
                note.done = !note.done;
                this.save();
            }
        },
        save() {
            localStorage.setItem('sticky_notes', JSON.stringify(this.notes));
        }
    }" class="space-y-4">

        <div class="flex gap-2">
            <input type="text"
                   x-model="newNote"
                   @keydown.enter="add"
                   placeholder="Novo lembrete..."
                   class="flex-1 rounded-md border-yellow-300 bg-white dark:bg-slate-800 dark:border-slate-600 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
            <button @click="add" class="p-2 text-yellow-600 hover:text-yellow-700 dark:text-yellow-400">
                <x-icon name="plus" />
            </button>
        </div>

        <ul class="space-y-2 max-h-60 overflow-y-auto pr-1">
            <template x-for="note in notes" :key="note.id">
                <li class="flex items-start gap-2 group p-2 rounded hover:bg-yellow-100 dark:hover:bg-yellow-900/20 transition-colors">
                    <button @click="toggle(note.id)" class="mt-0.5 text-yellow-500 hover:text-yellow-600">
                        <x-icon ::name="note.done ? 'check-square' : 'square'" style="regular" />
                    </button>
                    <span class="flex-1 text-sm text-slate-700 dark:text-slate-300 break-words"
                          :class="{ 'line-through opacity-50': note.done }"
                          x-text="note.text"></span>
                    <button @click="remove(note.id)" class="opacity-0 group-hover:opacity-100 text-red-400 hover:text-red-500 transition-opacity">
                        <x-icon name="times" />
                    </button>
                </li>
            </template>
            <div x-show="notes.length === 0" class="text-center text-sm text-yellow-600/50 italic py-4">
                Nenhum lembrete.
            </div>
        </ul>
    </div>
</x-card>
