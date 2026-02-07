<div class="bg-white dark:bg-slate-900 rounded-lg shadow p-4 h-full border border-slate-200 dark:border-slate-800 flex flex-col">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-poppins font-semibold text-lg text-slate-800 dark:text-slate-100">
            Resumo de Frequência
        </h3>
        <x-icon name="chart-pie" class="w-5 h-5 text-indigo-500" />
    </div>

    <div class="flex-1 flex items-end justify-between gap-2 h-32 px-2 pb-6">
        <!-- Bar 1 -->
        <div class="w-full flex flex-col justify-end items-center h-full group relative">
            <div class="absolute bottom-full mb-1 text-xs text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">60%</div>
            <div class="w-full bg-indigo-500 rounded-t-md hover:bg-indigo-600 transition-colors" style="height: 60%;"></div>
            <div class="text-xs text-center mt-1 text-slate-500 absolute top-full">Seg</div>
        </div>
        <!-- Bar 2 -->
        <div class="w-full flex flex-col justify-end items-center h-full group relative">
             <div class="absolute bottom-full mb-1 text-xs text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">85%</div>
            <div class="w-full bg-indigo-500 rounded-t-md hover:bg-indigo-600 transition-colors" style="height: 85%;"></div>
            <div class="text-xs text-center mt-1 text-slate-500 absolute top-full">Ter</div>
        </div>
        <!-- Bar 3 -->
        <div class="w-full flex flex-col justify-end items-center h-full group relative">
             <div class="absolute bottom-full mb-1 text-xs text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">45%</div>
            <div class="w-full bg-indigo-500 rounded-t-md hover:bg-indigo-600 transition-colors" style="height: 45%;"></div>
            <div class="text-xs text-center mt-1 text-slate-500 absolute top-full">Qua</div>
        </div>
        <!-- Bar 4 -->
        <div class="w-full flex flex-col justify-end items-center h-full group relative">
             <div class="absolute bottom-full mb-1 text-xs text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">90%</div>
            <div class="w-full bg-indigo-500 rounded-t-md hover:bg-indigo-600 transition-colors" style="height: 90%;"></div>
            <div class="text-xs text-center mt-1 text-slate-500 absolute top-full">Qui</div>
        </div>
        <!-- Bar 5 -->
        <div class="w-full flex flex-col justify-end items-center h-full group relative">
             <div class="absolute bottom-full mb-1 text-xs text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">75%</div>
            <div class="w-full bg-indigo-500 rounded-t-md hover:bg-indigo-600 transition-colors" style="height: 75%;"></div>
            <div class="text-xs text-center mt-1 text-slate-500 absolute top-full">Sex</div>
        </div>
    </div>
</div>
