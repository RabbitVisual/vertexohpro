<x-teacherpanel::layouts.master title="Criar Plano de Aula">
    <div x-data="lessonPlanEditor()" x-init="restoreDraft()" class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 flex flex-col md:flex-row relative">

        <!-- Draft Notification -->
        <div x-show="hasDraft" x-transition class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-xl flex items-center gap-4">
            <span><i class="fa-duotone fa-floppy-disk"></i> Rascunho encontrado!</span>
            <div class="flex gap-2">
                <button @click="loadDraft()" class="bg-white text-indigo-600 px-3 py-1 rounded font-bold text-sm hover:bg-slate-100">Restaurar</button>
                <button @click="discardDraft()" class="bg-indigo-700 text-white px-3 py-1 rounded font-bold text-sm hover:bg-indigo-800">Descartar</button>
            </div>
        </div>

        <!-- Left Column: Writing Panel -->
        <div class="flex-1 p-6 md:p-8 overflow-y-auto">
            <header class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 dark:text-white font-poppins mb-2">Novo Plano de Aula</h1>
                    <p class="text-slate-400">Desenvolva sua aula com assistência da BNCC.</p>
                    <span x-show="lastSaved" class="text-xs text-emerald-400 mt-1 block">
                        <i class="fa-duotone fa-check-circle"></i> Salvo em: <span x-text="lastSaved"></span>
                    </span>
                </div>
                <div class="flex gap-3">
                    <button @click="showPreview = true" type="button" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-lg transition border border-slate-700 flex items-center gap-2">
                        <i class="fa-duotone fa-print"></i>
                        <span class="hidden md:inline">Visualizar Impressão</span>
                    </button>
                    <button type="submit" form="lesson-plan-form" @click="clearDraft()" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg shadow-lg shadow-indigo-900/50 transition font-medium flex items-center gap-2">
                        <i class="fa-duotone fa-save"></i>
                        <span>Salvar Plano</span>
                    </button>
                </div>
            </header>

            <form id="lesson-plan-form" action="{{ route('planning.lesson-plans.store') }}" method="POST" class="space-y-6 max-w-4xl mx-auto">
                @csrf

                <!-- Main Title -->
                <div class="bg-slate-900/50 p-6 rounded-xl border border-slate-800">
                    <label class="block text-sm font-medium text-slate-400 mb-2 uppercase tracking-wider">Título da Aula</label>
                    <input type="text" name="title" x-model="title" required class="w-full bg-slate-950 border-slate-800 text-white text-xl rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-600" placeholder="Ex: Introdução à Geografia Física">
                </div>

                <!-- Dynamic Sections -->
                <div class="space-y-6" id="sections-container">
                    <template x-for="(section, index) in sections" :key="section.id">
                        <div
                            class="group bg-slate-900/50 p-6 rounded-xl border border-slate-800 transition-all hover:border-slate-700 relative"
                            draggable="true"
                            @dragstart="dragStart($event, index)"
                            @dragover.prevent="dragOver($event, index)"
                            @drop="drop($event, index)"
                            :class="{ 'opacity-50 border-dashed border-indigo-500': draggedIndex === index }"
                        >
                            <!-- Drag Handle -->
                            <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                <button type="button" class="cursor-move text-slate-500 hover:text-white p-2" title="Reordenar">
                                    <i class="fa-duotone fa-grip-vertical"></i>
                                </button>
                                <button type="button" @click="removeSection(index)" class="text-slate-500 hover:text-red-400 p-2" title="Remover Seção">
                                    <i class="fa-duotone fa-trash"></i>
                                </button>
                            </div>

                            <div class="mb-4 pr-12">
                                <input type="text" :name="'sections[' + index + '][title]'" x-model="section.title" class="bg-transparent border-0 border-b border-slate-800 text-lg font-semibold text-indigo-400 focus:ring-0 focus:border-indigo-500 w-full placeholder-slate-600" placeholder="Título da Seção">
                            </div>

                            <!-- Rich Text Editor -->
                            <div class="bg-slate-950 rounded-lg border border-slate-800 min-h-[150px] overflow-hidden" wire:ignore>
                                <div :id="'editor-' + section.id" x-init="initQuill(section.id, index)" class="text-slate-300 h-full"></div>
                                <input type="hidden" :name="'sections[' + index + '][content]'" :value="section.content">
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Add Section Button -->
                <button type="button" @click="addSection()" class="w-full py-4 border-2 border-dashed border-slate-800 rounded-xl text-slate-500 hover:text-indigo-400 hover:border-indigo-500/50 hover:bg-slate-900/50 transition flex items-center justify-center gap-2">
                    <i class="fa-duotone fa-plus-circle"></i>
                    <span>Adicionar Nova Seção</span>
                </button>
            </form>
        </div>

        <!-- Right Column: BNCC Assistant -->
        <aside class="w-full md:w-96 bg-slate-900 border-l border-slate-800 flex flex-col fixed md:relative bottom-0 h-[60vh] md:h-auto z-20 shadow-2xl md:shadow-none transform transition-transform duration-300"
               :class="{ 'translate-y-0': showAssistant, 'translate-y-full md:translate-y-0': !showAssistant }">

            <div class="p-6 border-b border-slate-800 flex justify-between items-center bg-slate-900">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fa-duotone fa-robot text-indigo-500"></i>
                    Assistente BNCC
                </h2>
                <button @click="showAssistant = false" class="md:hidden text-slate-400 hover:text-white" aria-label="Fechar Assistente">
                    <i class="fa-solid fa-times"></i>
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
                        class="w-full bg-slate-950 border-slate-700 text-slate-200 rounded-lg pr-10 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    <button @click="searchBncc()" class="absolute right-3 top-2.5 text-slate-400 hover:text-indigo-400" aria-label="Buscar">
                        <i class="fa-duotone fa-search" :class="{ 'fa-spin': isSearching }"></i>
                    </button>
                </div>

                <!-- Results -->
                <div class="space-y-4">
                    <template x-if="bnccResults.length === 0 && !isSearching">
                        <div class="text-center text-slate-500 py-8">
                            <i class="fa-duotone fa-books text-3xl mb-2 opacity-50"></i>
                            <p class="text-sm">Digite um código para buscar sugestões mágicas.</p>
                        </div>
                    </template>

                    <template x-for="skill in bnccResults" :key="skill.skill_code">
                        <div class="bg-slate-800/50 rounded-lg p-4 border border-slate-700 hover:border-indigo-500/50 transition group">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-xs font-bold bg-indigo-900/50 text-indigo-300 px-2 py-1 rounded" x-text="skill.skill_code"></span>
                                <button @click="magicFill(skill)" class="text-slate-400 hover:text-indigo-400" title="Aplicar Magia" aria-label="Aplicar Magia">
                                    <i class="fa-duotone fa-wand-magic-sparkles"></i>
                                </button>
                            </div>
                            <p class="text-sm text-slate-300 mb-3 line-clamp-3" x-text="skill.description"></p>

                            <!-- Draggable Item -->
                            <div
                                draggable="true"
                                @dragstart="dragSkillStart($event, skill)"
                                class="bg-slate-950 p-2 rounded text-xs text-slate-400 cursor-move border border-slate-800 hover:border-indigo-500 flex items-center gap-2"
                            >
                                <i class="fa-duotone fa-grip-dots-vertical"></i>
                                Arraste para o editor
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </aside>

        <!-- Mobile Toggle Button -->
        <button @click="showAssistant = !showAssistant" class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-indigo-600 text-white rounded-full shadow-lg shadow-indigo-900/50 flex items-center justify-center z-30" aria-label="Abrir Assistente">
            <i class="fa-duotone fa-robot text-xl"></i>
        </button>

        <!-- Preview Modal -->
        <div x-show="showPreview" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm" @click.self="showPreview = false">
            <div class="bg-white text-black w-full max-w-4xl h-[90vh] rounded-xl overflow-hidden flex flex-col shadow-2xl">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="font-serif font-bold text-xl text-gray-800">Visualização de Impressão</h3>
                    <button @click="showPreview = false" class="text-gray-500 hover:text-red-500" aria-label="Fechar">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-8 bg-gray-100">
                    <div class="bg-white shadow-lg p-12 min-h-full max-w-[21cm] mx-auto font-serif leading-relaxed">
                        <div class="text-center border-b-2 border-black pb-4 mb-6">
                            <h1 class="text-2xl font-bold uppercase mb-2">Planejamento de Aula</h1>
                            <p class="text-sm text-gray-600">Documento Oficial</p>
                        </div>

                        <div class="mb-6">
                            <strong>Título:</strong> <span x-text="title || 'Sem título'"></span>
                        </div>

                        <template x-for="section in sections" :key="section.id">
                            <div class="mb-6">
                                <h4 class="font-bold bg-gray-200 p-2 border border-black mb-2 uppercase text-sm" x-text="section.title"></h4>
                                <div class="border border-black p-4 text-sm whitespace-pre-wrap" x-html="section.content"></div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                    <button @click="showPreview = false" class="px-6 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">Fechar</button>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div x-show="isSearching" class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-slate-900 p-6 rounded-xl shadow-2xl flex flex-col items-center">
                <i class="fa-duotone fa-spinner-third fa-spin text-4xl text-indigo-500 mb-4"></i>
                <p class="text-slate-300 font-medium">Consultando Oráculo BNCC...</p>
            </div>
        </div>

    </div>

    @push('scripts')
    <script src="{{ asset('vendor/quill/quill.js') }}"></script>
    <script>
        function lessonPlanEditor() {
            return {
                title: '',
                sections: [
                    { id: 1, title: 'Objetivos de Aprendizagem', content: '' },
                    { id: 2, title: 'Conteúdo Programático', content: '' },
                    { id: 3, title: 'Metodologia', content: '' },
                    { id: 4, title: 'Avaliação', content: '' }
                ],
                bnccQuery: '',
                bnccResults: [],
                isSearching: false,
                showAssistant: false,
                showPreview: false,
                draggedIndex: null,
                quillInstances: {},
                hasDraft: false,
                lastSaved: null,
                saveInterval: null,

                init() {
                    // Start auto-save
                    this.saveInterval = setInterval(() => {
                        this.saveDraft();
                    }, 30000); // 30s
                },

                restoreDraft() {
                    const draft = localStorage.getItem('lesson_plan_draft');
                    if (draft) {
                        this.hasDraft = true;
                    }
                },

                loadDraft() {
                    const draft = JSON.parse(localStorage.getItem('lesson_plan_draft'));
                    if (draft) {
                        this.title = draft.title || '';
                        this.sections = draft.sections || [];
                        this.lastSaved = new Date().toLocaleTimeString();

                        this.$nextTick(() => {
                            this.sections.forEach((section, index) => {
                                if (this.quillInstances[section.id]) {
                                    this.quillInstances[section.id].root.innerHTML = section.content;
                                }
                            });
                        });

                        this.hasDraft = false;
                    }
                },

                discardDraft() {
                    localStorage.removeItem('lesson_plan_draft');
                    this.hasDraft = false;
                },

                saveDraft() {
                    if (!this.title && this.sections.every(s => !s.content)) return;

                    const draft = {
                        title: this.title,
                        sections: this.sections
                    };
                    localStorage.setItem('lesson_plan_draft', JSON.stringify(draft));
                    this.lastSaved = new Date().toLocaleTimeString();
                },

                clearDraft() {
                    localStorage.removeItem('lesson_plan_draft');
                    if (this.saveInterval) clearInterval(this.saveInterval);
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

                        this.$watch('sections', (val) => {
                            const currentSection = val.find(s => s.id === id);
                            if (currentSection && currentSection.content !== quill.root.innerHTML) {
                                quill.root.innerHTML = currentSection.content;
                            }
                        });
                    });
                },

                async searchBncc() {
                    if (!this.bnccQuery) return;
                    this.isSearching = true;
                    this.bnccResults = [];

                    try {
                        const response = await fetch(`/api/v1/bncc/search?q=${this.bnccQuery}`);
                        if (response.ok) {
                            const data = await response.json();
                            // If it returns multiple, show all, if one, map it
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

                    if (skill.suggested_materials) {
                        let resourcesSection = this.sections.find(s => s.title.includes('Recursos'));
                        if (!resourcesSection) {
                            this.addSection('Recursos Didáticos');
                            setTimeout(() => {
                                resourcesSection = this.sections.find(s => s.title === 'Recursos Didáticos');
                                if (resourcesSection) {
                                     const content = skill.suggested_materials.map(m => `<li>${m}</li>`).join('');
                                     resourcesSection.content = `<ul>${content}</ul>`;
                                }
                            }, 50);
                        } else {
                            const content = skill.suggested_materials.map(m => `<li>${m}</li>`).join('');
                            resourcesSection.content = `<ul>${content}</ul>`;
                        }
                    }
                    this.saveDraft();
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
        .ql-toolbar { border-color: #1e293b !important; background: #0f172a; color: white; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; }
        .ql-container { border-color: #1e293b !important; background: #0f172a; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; font-family: 'Inter', sans-serif; font-size: 1rem; }
        .ql-editor { min-height: 150px; }
        .ql-stroke { stroke: #94a3b8 !important; }
        .ql-fill { fill: #94a3b8 !important; }
        .ql-picker { color: #94a3b8 !important; }
    </style>
    @endpush
</x-teacherpanel::layouts.master>
