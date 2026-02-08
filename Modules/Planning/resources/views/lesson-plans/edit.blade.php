<x-teacherpanel::layouts.master title="Editar Plano de Aula">
    <div x-data="lessonPlanEditor()" x-init="initEdit()" class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 flex flex-col md:flex-row relative">

        <!-- Left Column: Writing Panel -->
        <div class="flex-1 p-6 md:p-8 overflow-y-auto">
            <header class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 dark:text-white font-poppins mb-2">Editar Plano de Aula</h1>
                    <p class="text-slate-400">Refine seu planejamento com assistência da BNCC.</p>
                </div>
                <div class="flex gap-3">
                    <button @click="showPreview = true" type="button" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-lg transition border border-slate-700 flex items-center gap-2">
                        <x-icon name="print" style="solid" class="w-4 h-4" />
                        <span class="hidden md:inline">Visualizar Impressão</span>
                    </button>
                    <button type="submit" form="lesson-plan-form" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg shadow-lg shadow-indigo-900/50 transition font-medium flex items-center gap-2">
                        <x-icon name="save" style="solid" class="w-4 h-4" />
                        <span>Atualizar Plano</span>
                    </button>
                </div>
            </header>

            <form id="lesson-plan-form" action="{{ route('planning.lesson-plans.update', $plan->id) }}" method="POST" class="space-y-6 max-w-4xl mx-auto">
                @csrf
                @method('PUT')

                <!-- Main Title -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <label class="block text-sm font-medium text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-wider">Título da Aula</label>
                    <input type="text" name="title" x-model="title" required class="w-full bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white text-xl rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400 dark:placeholder-slate-600" placeholder="Ex: Introdução à Geografia Física">
                </div>

                <!-- Dynamic Sections -->
                <div class="space-y-6" id="sections-container">
                    <template x-for="(section, index) in sections" :key="section.id">
                        <div
                            class="group bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:border-indigo-300 dark:hover:border-indigo-500 relative"
                            draggable="true"
                            @dragstart="dragStart($event, index)"
                            @dragover.prevent="dragOver($event, index)"
                            @drop="drop($event, index)"
                            :class="{ 'opacity-50 border-dashed border-indigo-500': draggedIndex === index }"
                        >
                            <!-- Drag Handle -->
                            <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                <button type="button" class="cursor-move text-slate-400 hover:text-indigo-500 p-2" title="Reordenar">
                                    <x-icon name="grip-vertical" style="solid" class="w-4 h-4" />
                                </button>
                                <button type="button" @click="removeSection(index)" class="text-slate-400 hover:text-red-500 p-2" title="Remover Seção">
                                    <x-icon name="trash" style="solid" class="w-4 h-4" />
                                </button>
                            </div>

                            <div class="mb-4 pr-12">
                                <input type="text" :name="'sections[' + index + '][title]'" x-model="section.title" class="bg-transparent border-0 border-b border-slate-200 dark:border-slate-800 text-lg font-semibold text-indigo-600 dark:text-indigo-400 focus:ring-0 focus:border-indigo-500 w-full placeholder-slate-400 dark:placeholder-slate-600" placeholder="Título da Seção">
                            </div>

                            <!-- Rich Text Editor -->
                            <div class="bg-slate-50 dark:bg-slate-950 rounded-lg border border-slate-200 dark:border-slate-800 min-h-[150px] overflow-hidden" wire:ignore>
                                <div :id="'editor-' + section.id" x-init="initQuill(section.id, index)" class="text-slate-700 dark:text-slate-300 h-full"></div>
                                <input type="hidden" :name="'sections[' + index + '][content]'" :value="section.content">
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Add Section Button -->
                <button type="button" @click="addSection()" class="w-full py-4 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-xl text-slate-400 hover:text-indigo-500 hover:border-indigo-500/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition flex items-center justify-center gap-2 font-medium">
                    <x-icon name="plus-circle" style="solid" class="w-5 h-5" />
                    <span>Adicionar Nova Seção</span>
                </button>
            </form>
        </div>

        <!-- Right Column: BNCC Assistant -->
        <aside class="w-full md:w-96 bg-white dark:bg-slate-900 border-l border-slate-200 dark:border-slate-800 flex flex-col fixed md:relative bottom-0 h-[60vh] md:h-auto z-20 shadow-2xl md:shadow-none transform transition-transform duration-300"
               :class="{ 'translate-y-0': showAssistant, 'translate-y-full md:translate-y-0': !showAssistant }">

            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-white dark:bg-slate-900">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-white flex items-center gap-2">
                    <x-icon name="robot" style="solid" class="w-5 h-5 text-indigo-500" />
                    Assistente BNCC
                </h2>
                <button @click="showAssistant = false" class="md:hidden text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <x-icon name="xmark" style="solid" class="w-5 h-5" />
                </button>
            </div>

            <div class="p-4 flex-1 overflow-y-auto">
                <!-- Search Box -->
                <div class="relative mb-6">
                    <input
                        type="text"
                        x-model="bnccQuery"
                        @keydown.enter.prevent="searchBncc()"
                        placeholder="Buscar habilidade (ex: EF01LP01)..."
                        class="w-full bg-slate-50 dark:bg-slate-950 border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200 rounded-lg pr-10 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    >
                    <button @click="searchBncc()" class="absolute right-3 top-2.5 text-slate-400 hover:text-indigo-500">
                        <x-icon name="magnifying-glass" style="solid" :class="{ 'fa-spin': isSearching }" class="w-4 h-4" />
                    </button>
                </div>

                <!-- Results -->
                <div class="space-y-4">
                    <template x-if="bnccResults.length === 0 && !isSearching">
                        <div class="text-center text-slate-400 py-8">
                            <x-icon name="books" style="solid" class="w-10 h-10 mb-2 opacity-30 mx-auto" />
                            <p class="text-xs">Digite um código para buscar sugestões mágicas.</p>
                        </div>
                    </template>

                    <template x-for="skill in bnccResults" :key="skill.skill_code">
                        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 border border-slate-200 dark:border-slate-700 hover:border-indigo-500/50 transition group">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-bold bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-300 px-2 py-1 rounded" x-text="skill.skill_code"></span>
                                <button @click="magicFill(skill)" class="text-slate-400 hover:text-indigo-500" title="Aplicar Magia">
                                    <x-icon name="wand-magic-sparkles" style="solid" class="w-4 h-4" />
                                </button>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-slate-300 mb-3 line-clamp-3" x-text="skill.description"></p>

                            <!-- Draggable Item -->
                            <div
                                draggable="true"
                                @dragstart="dragSkillStart($event, skill)"
                                class="bg-white dark:bg-slate-950 p-2 rounded text-[10px] text-slate-400 cursor-move border border-slate-100 dark:border-slate-800 hover:border-indigo-500 flex items-center gap-2"
                            >
                                <x-icon name="grip-dots-vertical" style="solid" class="w-3 h-3" />
                                Arraste para o editor
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </aside>

        <!-- Mobile Toggle Button -->
        <button @click="showAssistant = !showAssistant" class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-indigo-600 text-white rounded-full shadow-lg shadow-indigo-900/20 flex items-center justify-center z-30">
            <x-icon name="robot" style="solid" class="w-6 h-6" />
        </button>

        <!-- Preview Modal -->
        <div x-show="showPreview" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" @click.self="showPreview = false">
            <div class="bg-white text-black w-full max-w-4xl h-[90vh] rounded-2xl overflow-hidden flex flex-col shadow-2xl">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-800">Visualização de Impressão</h3>
                    <button @click="showPreview = false" class="text-gray-400 hover:text-red-500">
                        <x-icon name="xmark" style="solid" class="w-6 h-6" />
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-8 bg-gray-100/50">
                    <div class="bg-white shadow-xl p-12 min-h-full max-w-[21cm] mx-auto font-serif leading-relaxed text-black">
                        <div class="text-center border-b-2 border-black pb-4 mb-8">
                            <h1 class="text-2xl font-bold uppercase mb-2">Planejamento de Aula</h1>
                            <p class="text-sm text-gray-600 tracking-widest">Documento Oficial • Vertex Oh Pro</p>
                        </div>

                        <div class="mb-8">
                            <p class="text-sm"><strong>Título:</strong> <span class="border-b border-gray-300 ml-2" x-text="title || 'Sem título'"></span></p>
                        </div>

                        <template x-for="section in sections" :key="section.id">
                            <div class="mb-8">
                                <h4 class="font-bold bg-gray-100 p-2 border border-black mb-3 uppercase text-xs tracking-wider" x-text="section.title"></h4>
                                <div class="p-4 text-sm whitespace-pre-wrap leading-relaxed" x-html="section.content"></div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <button @click="showPreview = false" class="px-6 py-2 bg-gray-800 text-white rounded-xl hover:bg-gray-700 transition font-bold text-sm">Fechar</button>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div x-show="isSearching" class="fixed inset-0 z-40 bg-black/10 backdrop-blur-[2px] flex items-center justify-center">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 flex flex-col items-center">
                <x-icon name="spinner-third" style="solid" class="w-10 h-10 text-indigo-600 dark:text-indigo-400 fa-spin mb-4" />
                <p class="text-slate-600 dark:text-slate-300 font-bold">Consultando Oráculo BNCC...</p>
            </div>
        </div>

    </div>

    @push('scripts')
    <script src="{{ asset('vendor/quill/quill.js') }}"></script>
    <script>
        function lessonPlanEditor() {
            return {
                title: @json($plan->title),
                sections: @json($plan->sections ?? []),
                bnccQuery: '',
                bnccResults: [],
                isSearching: false,
                showAssistant: false,
                showPreview: false,
                draggedIndex: null,
                quillInstances: {},

                initEdit() {
                    if (!this.sections || this.sections.length === 0) {
                        this.sections = [
                            { id: 1, title: 'Objetivos de Aprendizagem', content: '' },
                            { id: 2, title: 'Conteúdo Programático', content: '' },
                            { id: 3, title: 'Metodologia', content: '' },
                            { id: 4, title: 'Avaliação', content: '' }
                        ];
                    }
                },

                initQuill(id, index) {
                    this.$nextTick(() => {
                        const el = document.getElementById('editor-' + id);
                        if (!el || this.quillInstances[id]) return;

                        const quill = new Quill('#editor-' + id, {
                            theme: 'snow',
                            placeholder: 'Escreva aqui...',
                            modules: {
                                toolbar: [
                                    ['bold', 'italic', 'underline'],
                                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                    ['clean']
                                ]
                            }
                        });

                        this.quillInstances[id] = quill;

                        // Set initial content
                        if (this.sections[index] && this.sections[index].content) {
                            quill.root.innerHTML = this.sections[index].content;
                        }

                        // Update model on change
                        quill.on('text-change', () => {
                            const currentSection = this.sections.find(s => s.id === id);
                            if (currentSection) {
                                currentSection.content = quill.root.innerHTML;
                            }
                        });
                    });
                },

                async searchBncc() {
                    if (!this.bnccQuery) return;
                    this.isSearching = true;

                    try {
                        const response = await fetch(`/bncc/search?q=${this.bnccQuery}`);
                        if (response.ok) {
                            const data = await response.json();
                            this.bnccResults = Array.isArray(data) ? data : [data];
                        }
                    } catch (error) {
                        console.error('Erro na busca BNCC:', error);
                    } finally {
                        this.isSearching = false;
                    }
                },

                magicFill(skill) {
                    const objectivesSection = this.sections.find(s => s.title.includes('Objetivos'));
                    if (objectivesSection && skill.suggested_objectives) {
                        const content = skill.suggested_objectives.map(o => `<li>${o}</li>`).join('');
                        objectivesSection.content = `<ul>${content}</ul>`;
                    }

                    const assessmentSection = this.sections.find(s => s.title.includes('Avaliação'));
                    if (assessmentSection && skill.suggested_assessment) {
                        const content = skill.suggested_assessment.map(a => `<li>${a}</li>`).join('');
                        assessmentSection.content = `<ul>${content}</ul>`;
                    }
                },

                addSection(title = 'Nova Seção') {
                    this.sections.push({
                        id: Date.now(),
                        title: title,
                        content: ''
                    });
                },

                removeSection(index) {
                    this.sections.splice(index, 1);
                },

                dragStart(event, index) {
                    if (event.target.closest('.ql-editor')) {
                        event.preventDefault();
                        return;
                    }
                    this.draggedIndex = index;
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/plain', index);
                },

                dragOver(event, index) {
                    if (this.draggedIndex !== null) {
                         event.preventDefault();
                    }
                },

                drop(event, index) {
                    const fromIndex = this.draggedIndex;
                    if (fromIndex === null || fromIndex === index) return;

                    const item = this.sections.splice(fromIndex, 1)[0];
                    this.sections.splice(index, 0, item);

                    this.draggedIndex = null;
                },

                dragSkillStart(event, skill) {
                    event.dataTransfer.setData('text/plain', skill.description);
                    event.dataTransfer.effectAllowed = 'copy';
                }
            }
        }
    </script>
    @endpush

    @push('styles')
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <style>
        .ql-toolbar { border-color: #e2e8f0 !important; background: #f8fafc; border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem; }
        .dark .ql-toolbar { border-color: #1e293b !important; background: #0f172a; }
        .ql-container { border-color: #e2e8f0 !important; border-bottom-left-radius: 0.75rem; border-bottom-right-radius: 0.75rem; font-family: 'Inter', sans-serif; font-size: 1rem; }
        .dark .ql-container { border-color: #1e293b !important; background: #0f172a; }
        .ql-editor { min-height: 150px; }
        .dark .ql-stroke { stroke: #94a3b8 !important; }
        .dark .ql-fill { fill: #94a3b8 !important; }
        .dark .ql-picker { color: #94a3b8 !important; }
    </style>
    @endpush
</x-teacherpanel::layouts.master>
