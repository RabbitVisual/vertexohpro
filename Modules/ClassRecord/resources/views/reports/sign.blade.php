<x-layouts.app :title="'Assinar Boletim - ' . $student->name">
    <div class="max-w-2xl mx-auto p-6 bg-slate-900 rounded-lg shadow-xl mt-10">
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
            <i class="fa-duotone fa-file-signature text-indigo-500 mr-3"></i>
            Assinatura Digital
        </h2>

        <p class="text-slate-300 mb-4">
            Assine abaixo para gerar e validar o boletim de <strong>{{ $student->name }}</strong>.
        </p>

        <div class="mb-6 relative">
            <canvas id="signature-pad" class="w-full h-64 bg-white rounded-lg cursor-crosshair border-2 border-slate-600 touch-none"></canvas>
            <div class="absolute top-2 right-2 text-xs text-slate-400 select-none pointer-events-none">
                Área de Assinatura
            </div>
        </div>

        <div class="flex justify-between items-center">
            <button type="button" id="clear-btn" class="px-4 py-2 bg-slate-700 text-slate-300 rounded hover:bg-slate-600 transition-colors">
                Limpar
            </button>

            <form id="sign-form" action="{{ route('classrecords.reports.generate', $student->id) }}" method="POST">
                @csrf
                <input type="hidden" name="signature" id="signature-input">
                <button type="submit" id="generate-btn" class="px-6 py-2 bg-indigo-600 text-white rounded font-bold hover:bg-indigo-500 transition-colors flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fa-duotone fa-file-pdf mr-2"></i>
                    Gerar Boletim
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('signature-pad');
            const ctx = canvas.getContext('2d');
            let isDrawing = false;
            let hasSignature = false;

            // Set canvas resolution for sharpness
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                ctx.scale(ratio, ratio);
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.strokeStyle = '#000000'; // Black signature
            }

            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            function getPos(e) {
                const rect = canvas.getBoundingClientRect();
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                return {
                    x: clientX - rect.left,
                    y: clientY - rect.top
                };
            }

            function start(e) {
                e.preventDefault();
                isDrawing = true;
                const pos = getPos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            }

            function draw(e) {
                if (!isDrawing) return;
                e.preventDefault();
                const pos = getPos(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
                hasSignature = true;
            }

            function stop(e) {
                if (isDrawing) {
                    e.preventDefault();
                    isDrawing = false;
                }
            }

            canvas.addEventListener('mousedown', start);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stop);
            canvas.addEventListener('mouseout', stop);

            canvas.addEventListener('touchstart', start);
            canvas.addEventListener('touchmove', draw);
            canvas.addEventListener('touchend', stop);

            document.getElementById('clear-btn').addEventListener('click', () => {
                ctx.clearRect(0, 0, canvas.width / (window.devicePixelRatio || 1), canvas.height / (window.devicePixelRatio || 1));
                hasSignature = false;
            });

            document.getElementById('sign-form').addEventListener('submit', (e) => {
                if (!hasSignature) {
                    e.preventDefault();
                    alert('Por favor, assine antes de gerar o boletim.');
                    return;
                }
                const dataUrl = canvas.toDataURL('image/png');
                document.getElementById('signature-input').value = dataUrl;
            });
        });
    </script>
</x-layouts.app>
