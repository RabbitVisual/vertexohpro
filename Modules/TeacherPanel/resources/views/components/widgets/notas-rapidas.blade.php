@props(['notes' => ''])
<div class="bg-white dark:bg-slate-900 rounded-lg shadow p-4 h-full border border-slate-200 dark:border-slate-800 flex flex-col min-h-[200px]"
     x-data='{
         notes: @json($notes),
         status: "",
         isSaving: false,
         save() {
             this.status = "Salvando...";
             this.isSaving = true;
             fetch("{{ route("teacherpanel.update_notes") }}", {
                 method: "POST",
                 headers: {
                     "Content-Type": "application/json",
                     "X-CSRF-TOKEN": "{{ csrf_token() }}",
                     "Accept": "application/json"
                 },
                 body: JSON.stringify({ notes: this.notes })
             })
             .then(response => {
                 this.isSaving = false;
                 if (response.ok) {
                     this.status = "Salvo";
                     setTimeout(() => this.status = "", 2000);
                 } else {
                     this.status = "Erro";
                 }
             })
             .catch(() => {
                 this.isSaving = false;
                 this.status = "Offline";
             });
         }
     }'>
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-poppins font-semibold text-lg text-slate-800 dark:text-slate-100 flex items-center gap-2">
            Notas Rápidas
            <x-icon name="pen-to-square" class="w-4 h-4 text-amber-500" />
        </h3>
        <span x-text="status" class="text-xs text-slate-500 italic transition-opacity duration-300"></span>
    </div>

    <textarea
        x-model="notes"
        @input.debounce.1000ms="save()"
        class="w-full flex-1 p-3 text-sm bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-md focus:ring-indigo-500 focus:border-indigo-500 resize-none min-h-[150px]"
        placeholder="Digite suas anotações aqui..."></textarea>
</div>
