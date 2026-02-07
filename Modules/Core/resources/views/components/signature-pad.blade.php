<div x-data="{
    drawing: false,
    context: null,
    preview: null,
    init() {
        const canvas = this.$refs.canvas;
        this.context = canvas.getContext('2d');
        this.context.lineWidth = 2;
        this.context.lineCap = 'round';
        this.context.strokeStyle = '#000';

        // Handle Resize? For now fixed size or responsive via CSS scale
        // Ideally handle resize events to clear/redraw
    },
    start(e) {
        this.drawing = true;
        this.draw(e);
    },
    stop() {
        this.drawing = false;
        this.context.beginPath();
    },
    draw(e) {
        if (!this.drawing) return;

        const canvas = this.$refs.canvas;
        const rect = canvas.getBoundingClientRect();

        let clientX, clientY;
        if (e.touches) {
            clientX = e.touches[0].clientX;
            clientY = e.touches[0].clientY;
        } else {
            clientX = e.clientX;
            clientY = e.clientY;
        }

        this.context.lineTo(clientX - rect.left, clientY - rect.top);
        this.context.stroke();
        this.context.beginPath();
        this.context.moveTo(clientX - rect.left, clientY - rect.top);
    },
    clear() {
        this.context.clearRect(0, 0, this.$refs.canvas.width, this.$refs.canvas.height);
        this.preview = null;
    },
    save() {
        this.preview = this.$refs.canvas.toDataURL();
        // Here you would typically emit an event or update a hidden input
        this.$dispatch('signature-saved', this.preview);
    }
}" class="w-full max-w-md mx-auto">

    <div class="mb-2 flex justify-between items-center">
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Assinatura Digital</label>
        <button x-show="preview" @click="preview = null" class="text-sm text-indigo-600 hover:text-indigo-800">
            Editar
        </button>
    </div>

    <!-- Canvas Area -->
    <div x-show="!preview" class="border-2 border-dashed border-slate-300 rounded-lg bg-white touch-none" style="height: 200px;">
        <canvas x-ref="canvas"
                width="400"
                height="200"
                class="w-full h-full cursor-crosshair"
                @mousedown="start"
                @mousemove="draw"
                @mouseup="stop"
                @mouseleave="stop"
                @touchstart.prevent="start"
                @touchmove.prevent="draw"
                @touchend.prevent="stop"
        ></canvas>
    </div>

    <!-- Preview Area -->
    <div x-show="preview" class="border border-slate-200 rounded-lg bg-slate-50 p-4 flex items-center justify-center" style="height: 200px;">
        <img :src="preview" alt="Assinatura" class="max-h-full">
    </div>

    <div class="mt-4 flex gap-2 justify-end" x-show="!preview">
        <x-button variant="secondary" @click="clear" size="sm" icon="trash">Limpar</x-button>
        <x-button @click="save" size="sm" icon="check">Confirmar & Visualizar</x-button>
    </div>

    <div class="mt-4 flex gap-2 justify-end" x-show="preview">
        <span class="text-xs text-slate-500 self-center italic">Assinatura confirmada. Pronto para fechar o ciclo.</span>
    </div>
</div>
