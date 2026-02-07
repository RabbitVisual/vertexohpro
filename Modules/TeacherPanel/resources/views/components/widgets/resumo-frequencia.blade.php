<div class="bg-white dark:bg-slate-900 rounded-lg shadow p-4 h-full border border-slate-200 dark:border-slate-800 flex flex-col"
     x-data="{
         init() {
             fetch('{{ route('teacherpanel.widgets.frequency') }}')
                 .then(res => res.json())
                 .then(data => {
                     this.renderChart(data);
                 })
                 .catch(err => console.error('Error loading frequency data:', err));
         },
         renderChart(data) {
             if (!window.Chart) return;

             const ctx = this.$refs.canvas.getContext('2d');
             new Chart(ctx, {
                 type: 'bar',
                 data: {
                     labels: data.labels,
                     datasets: [{
                         label: 'Presença (%)',
                         data: data.data,
                         backgroundColor: '#6366f1',
                         borderRadius: 4,
                         hoverBackgroundColor: '#4f46e5'
                     }]
                 },
                 options: {
                     responsive: true,
                     maintainAspectRatio: false,
                     plugins: {
                         legend: { display: false },
                         tooltip: {
                             callbacks: {
                                 label: function(context) {
                                     return context.raw + '%';
                                 }
                             }
                         }
                     },
                     scales: {
                         y: {
                             beginAtZero: true,
                             max: 100,
                             ticks: {
                                 callback: function(value) { return value + '%' }
                             },
                             grid: {
                                 color: '#e2e8f0',
                                 drawBorder: false,
                             }
                         },
                         x: {
                             grid: { display: false }
                         }
                     }
                 }
             });
         }
     }">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-poppins font-semibold text-lg text-slate-800 dark:text-slate-100">
            Resumo de Frequência
        </h3>
        <x-icon name="chart-pie" class="w-5 h-5 text-indigo-500" />
    </div>

    <div class="flex-1 relative h-48 w-full">
        <canvas x-ref="canvas"></canvas>
    </div>
</div>
