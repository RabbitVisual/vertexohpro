@props(['classId'])

<div class="bg-white dark:bg-slate-900 rounded-lg shadow p-4 h-full border border-slate-200 dark:border-slate-800 flex flex-col"
     x-data="{
         init() {
             fetch('{{ route('classrecord.insights.difficulty_map', ['classId' => $classId]) }}')
                 .then(res => res.json())
                 .then(data => {
                     this.renderChart(data);
                 })
                 .catch(err => console.error('Error loading difficulty map:', err));
         },
         renderChart(data) {
             if (!window.Chart) return;

             const ctx = this.$refs.canvas.getContext('2d');
             new Chart(ctx, {
                 type: 'bar', // or 'radar'
                 data: {
                     labels: data.labels,
                     datasets: [{
                         label: 'Média da Turma',
                         data: data.data,
                         backgroundColor: data.data.map(v => v < 5 ? '#ef4444' : '#f59e0b'), // Red if < 5, Amber otherwise
                         borderRadius: 4,
                     }]
                 },
                 options: {
                     indexAxis: 'y', // Horizontal bar chart is often better for long labels
                     responsive: true,
                     maintainAspectRatio: false,
                     plugins: {
                         legend: { display: false },
                         title: { display: true, text: 'Habilidades com Menor Desempenho' }
                     },
                     scales: {
                         x: {
                             beginAtZero: true,
                             max: 10,
                             title: { display: true, text: 'Nota Média (0-10)' }
                         }
                     }
                 }
             });
         }
     }">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-poppins font-semibold text-lg text-slate-800 dark:text-slate-100">
            Mapa de Dificuldades BNCC
        </h3>
        <x-icon name="chart-simple" class="w-5 h-5 text-indigo-500" />
    </div>

    <div class="flex-1 relative h-64 w-full">
        <canvas x-ref="canvas"></canvas>
    </div>
</div>
