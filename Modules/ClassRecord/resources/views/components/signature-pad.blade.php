@props(['name' => 'signature', 'label' => 'Assinatura Digital'])

<div x-data="signaturePad()" class="w-full">
    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>

    <div class="relative w-full h-48 bg-white border-2 border-dashed border-gray-300 rounded-lg shadow-inner overflow-hidden touch-none" id="signature-container">
        <canvas x-ref="canvas" class="absolute inset-0 w-full h-full cursor-crosshair"></canvas>

        <!-- Placeholder text -->
        <div x-show="isEmpty" class="absolute inset-0 flex items-center justify-center pointer-events-none text-gray-400">
            <span class="text-sm">Assine aqui com o dedo ou mouse</span>
        </div>
    </div>

    <input type="hidden" name="{{ $name }}" x-model="signatureData">

    <div class="mt-2 flex justify-end">
        <button type="button" @click="clear()" class="text-sm text-red-600 hover:text-red-800 font-medium">
            Limpar Assinatura
        </button>
    </div>

    <script>
        function signaturePad() {
            return {
                signatureData: '',
                isEmpty: true,
                isDrawing: false,
                ctx: null,

                init() {
                    const canvas = this.$refs.canvas;
                    // Resize canvas to match display size
                    this.resizeCanvas();
                    window.addEventListener('resize', () => this.resizeCanvas());

                    this.ctx = canvas.getContext('2d');
                    this.ctx.lineWidth = 2;
                    this.ctx.lineCap = 'round';
                    this.ctx.strokeStyle = '#000';

                    // Mouse Events
                    canvas.addEventListener('mousedown', (e) => this.startDrawing(e));
                    canvas.addEventListener('mousemove', (e) => this.draw(e));
                    canvas.addEventListener('mouseup', () => this.stopDrawing());
                    canvas.addEventListener('mouseleave', () => this.stopDrawing());

                    // Touch Events (Passive false needed for preventDefault)
                    canvas.addEventListener('touchstart', (e) => this.startDrawing(e), { passive: false });
                    canvas.addEventListener('touchmove', (e) => this.draw(e), { passive: false });
                    canvas.addEventListener('touchend', () => this.stopDrawing());
                },

                resizeCanvas() {
                    const canvas = this.$refs.canvas;
                    const rect = canvas.getBoundingClientRect();
                    canvas.width = rect.width;
                    canvas.height = rect.height;
                    // Re-setup context after resize clears it
                    if (this.ctx) {
                        this.ctx.lineWidth = 2;
                        this.ctx.lineCap = 'round';
                        this.ctx.strokeStyle = '#000';
                    }
                },

                getPos(e) {
                    const canvas = this.$refs.canvas;
                    const rect = canvas.getBoundingClientRect();

                    let clientX, clientY;

                    if (e.touches && e.touches.length > 0) {
                        clientX = e.touches[0].clientX;
                        clientY = e.touches[0].clientY;
                    } else {
                        clientX = e.clientX;
                        clientY = e.clientY;
                    }

                    return {
                        x: clientX - rect.left,
                        y: clientY - rect.top
                    };
                },

                startDrawing(e) {
                    e.preventDefault();
                    this.isDrawing = true;
                    this.isEmpty = false;
                    const pos = this.getPos(e);
                    this.ctx.beginPath();
                    this.ctx.moveTo(pos.x, pos.y);
                },

                draw(e) {
                    if (!this.isDrawing) return;
                    e.preventDefault();
                    const pos = this.getPos(e);
                    this.ctx.lineTo(pos.x, pos.y);
                    this.ctx.stroke();
                },

                stopDrawing() {
                    if (this.isDrawing) {
                        this.isDrawing = false;
                        this.signatureData = this.$refs.canvas.toDataURL();
                    }
                },

                clear() {
                    const canvas = this.$refs.canvas;
                    this.ctx.clearRect(0, 0, canvas.width, canvas.height);
                    this.signatureData = '';
                    this.isEmpty = true;
                }
            }
        }
    </script>
</div>
