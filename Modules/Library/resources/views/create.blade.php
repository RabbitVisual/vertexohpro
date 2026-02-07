<x-core::layouts.master title="Publicar Material">
    <div class="p-6 max-w-4xl mx-auto">
        <header class="mb-8">
            <a href="{{ route('library.index') }}" class="text-slate-400 hover:text-white mb-2 inline-block transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Voltar para Biblioteca
            </a>
            <h1 class="text-3xl font-bold text-slate-100 font-poppins">Publicar Novo Material</h1>
            <p class="text-slate-400">Compartilhe seu conhecimento e receba por isso.</p>
        </header>

        <form action="{{ route('library.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ price: 0, isFree: false }">
            @csrf

            <!-- Basic Info -->
            <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800 space-y-6 shadow-xl">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                    <i class="fa-duotone fa-info-circle text-indigo-500"></i> Informações Básicas
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-2 uppercase tracking-wider text-xs">Título do Material</label>
                        <input type="text" name="title" required class="w-full bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 placeholder-slate-600 py-3" placeholder="Ex: Apostila de Matemática - 5º Ano">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2 uppercase tracking-wider text-xs">Disciplina</label>
                        <select name="subject" class="w-full bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 py-3">
                            <option value="">Selecione...</option>
                            <option value="Matemática">Matemática</option>
                            <option value="Português">Português</option>
                            <option value="História">História</option>
                            <option value="Geografia">Geografia</option>
                            <option value="Ciências">Ciências</option>
                            <option value="Artes">Artes</option>
                            <option value="Inglês">Inglês</option>
                            <option value="Educação Física">Educação Física</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2 uppercase tracking-wider text-xs">Preço (R$)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-slate-500 font-bold">R$</span>
                            <input type="number" name="price" step="0.01" min="0" x-model="price" :disabled="isFree" class="w-full bg-slate-950 border-slate-700 text-white pl-12 rounded-xl focus:ring-indigo-500 py-3" placeholder="0,00">
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <input type="checkbox" id="isFree" x-model="isFree" @change="price = isFree ? 0 : price" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-indigo-500 w-5 h-5">
                            <label for="isFree" class="text-sm text-slate-400 font-medium">Material Gratuito</label>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-2 uppercase tracking-wider text-xs">Descrição</label>
                        <textarea name="description" rows="4" required class="w-full bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 placeholder-slate-600 py-3" placeholder="Descreva o conteúdo, objetivos e público-alvo..."></textarea>
                    </div>

                    <!-- Tags Input (Alpine) -->
                    <div class="col-span-2" x-data="{ tags: [], newTag: '' }">
                        <label class="block text-sm font-medium text-slate-400 mb-2 uppercase tracking-wider text-xs">Tags (Palavras-chave)</label>
                        <div class="flex gap-2 mb-3 flex-wrap">
                            <template x-for="(tag, index) in tags" :key="index">
                                <span class="bg-indigo-900/50 text-indigo-300 px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-2 border border-indigo-500/30">
                                    <span x-text="tag"></span>
                                    <button type="button" @click="tags.splice(index, 1)" class="hover:text-white"><i class="fa-solid fa-times"></i></button>
                                    <input type="hidden" name="tags[]" :value="tag">
                                </span>
                            </template>
                        </div>
                        <div class="flex gap-2">
                            <input type="text" x-model="newTag" @keydown.enter.prevent="if(newTag.trim()) { tags.push(newTag.trim()); newTag = ''; }" placeholder="Digite uma tag e aperte Enter" class="flex-1 bg-slate-950 border-slate-700 text-white rounded-xl focus:ring-indigo-500 py-3">
                            <button type="button" @click="if(newTag.trim()) { tags.push(newTag.trim()); newTag = ''; }" class="bg-slate-800 text-white px-6 py-3 rounded-xl hover:bg-slate-700 font-bold transition">Adicionar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Uploads -->
            <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800 space-y-6 shadow-xl">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                    <i class="fa-duotone fa-cloud-arrow-up text-indigo-500"></i> Arquivos
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2 uppercase tracking-wider text-xs">Arquivo Principal (PDF)</label>
                        <div class="border-2 border-dashed border-slate-700 rounded-2xl p-8 text-center hover:border-indigo-500 transition cursor-pointer relative group bg-slate-950/50">
                            <input type="file" name="file" accept="application/pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="space-y-3">
                                <i class="fa-duotone fa-file-pdf text-5xl text-slate-600 group-hover:text-indigo-400 transition"></i>
                                <p class="text-sm text-slate-400 font-bold group-hover:text-white">Clique ou arraste o PDF</p>
                                <p class="text-[10px] text-slate-600 font-bold uppercase tracking-widest">Tamanho Máximo: 10MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Image -->
                    <div x-data="{ previewUrl: null }">
                        <label class="block text-sm font-medium text-slate-400 mb-2 uppercase tracking-wider text-xs">Capa / Preview (Imagem)</label>
                        <div class="border-2 border-dashed border-slate-700 rounded-2xl p-8 text-center hover:border-indigo-500 transition cursor-pointer relative group h-44 flex flex-col items-center justify-center overflow-hidden bg-slate-950/50">
                            <input type="file" name="preview_image" accept="image/*" @change="previewUrl = URL.createObjectURL($event.target.files[0])" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                            <template x-if="!previewUrl">
                                <div class="space-y-3">
                                    <i class="fa-duotone fa-image text-5xl text-slate-600 group-hover:text-indigo-400 transition"></i>
                                    <p class="text-sm text-slate-400 font-bold group-hover:text-white">Upload da Capa</p>
                                </div>
                            </template>

                            <template x-if="previewUrl">
                                <img :src="previewUrl" class="absolute inset-0 w-full h-full object-cover">
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-6 items-center">
                <a href="{{ route('library.index') }}" class="text-slate-500 hover:text-white transition font-medium">Cancelar</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-10 py-4 rounded-xl font-bold shadow-lg shadow-indigo-900/50 transition transform hover:-translate-y-1 active:translate-y-0">
                    Publicar Material
                </button>
            </div>
        </form>
    </div>
</x-core::layouts.master>
