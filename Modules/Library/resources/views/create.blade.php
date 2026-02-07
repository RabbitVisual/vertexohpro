<x-core::layouts.master title="Publicar Material">
    <div class="p-6 max-w-4xl mx-auto">
        <header class="mb-8">
            <a href="{{ route('library.index') }}" class="text-slate-400 hover:text-white mb-2 inline-block">
                <i class="fa-solid fa-arrow-left"></i> Voltar para Biblioteca
            </a>
            <h1 class="text-3xl font-bold text-slate-100 font-poppins">Publicar Novo Material</h1>
            <p class="text-slate-400">Compartilhe seu conhecimento e receba por isso.</p>
        </header>

        <form action="{{ route('library.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ price: 0, isFree: false }">
            @csrf

            <!-- Basic Info -->
            <div class="bg-slate-900 p-6 rounded-xl border border-slate-800 space-y-6">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                    <i class="fa-duotone fa-info-circle text-indigo-500"></i> Informações Básicas
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-2">Título do Material</label>
                        <input type="text" name="title" required class="w-full bg-slate-950 border-slate-700 text-white rounded-lg focus:ring-indigo-500 placeholder-slate-600" placeholder="Ex: Apostila de Matemática - 5º Ano">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2">Disciplina</label>
                        <select name="subject" class="w-full bg-slate-950 border-slate-700 text-white rounded-lg focus:ring-indigo-500">
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
                        <label class="block text-sm font-medium text-slate-400 mb-2">Preço (R$)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-slate-500">R$</span>
                            <input type="number" name="price" step="0.01" min="0" x-model="price" :disabled="isFree" class="w-full bg-slate-950 border-slate-700 text-white pl-10 rounded-lg focus:ring-indigo-500" placeholder="0,00">
                        </div>
                        <div class="mt-2 flex items-center gap-2">
                            <input type="checkbox" id="isFree" x-model="isFree" @change="price = isFree ? 0 : price" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-indigo-500">
                            <label for="isFree" class="text-sm text-slate-400">Material Gratuito</label>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-400 mb-2">Descrição</label>
                        <textarea name="description" rows="4" required class="w-full bg-slate-950 border-slate-700 text-white rounded-lg focus:ring-indigo-500 placeholder-slate-600" placeholder="Descreva o conteúdo, objetivos e público-alvo..."></textarea>
                    </div>

                    <!-- Tags Input (Alpine) -->
                    <div class="col-span-2" x-data="{ tags: [], newTag: '' }">
                        <label class="block text-sm font-medium text-slate-400 mb-2">Tags (Palavras-chave)</label>
                        <div class="flex gap-2 mb-2 flex-wrap">
                            <template x-for="(tag, index) in tags" :key="index">
                                <span class="bg-indigo-900/50 text-indigo-300 px-2 py-1 rounded text-sm flex items-center gap-1 border border-indigo-500/30">
                                    <span x-text="tag"></span>
                                    <button type="button" @click="tags.splice(index, 1)" class="hover:text-white">&times;</button>
                                    <input type="hidden" name="tags[]" :value="tag">
                                </span>
                            </template>
                        </div>
                        <div class="flex gap-2">
                            <input type="text" x-model="newTag" @keydown.enter.prevent="if(newTag.trim()) { tags.push(newTag.trim()); newTag = ''; }" placeholder="Digite uma tag e aperte Enter" class="flex-1 bg-slate-950 border-slate-700 text-white rounded-lg focus:ring-indigo-500">
                            <button type="button" @click="if(newTag.trim()) { tags.push(newTag.trim()); newTag = ''; }" class="bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-700">Adicionar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Uploads -->
            <div class="bg-slate-900 p-6 rounded-xl border border-slate-800 space-y-6">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                    <i class="fa-duotone fa-cloud-arrow-up text-indigo-500"></i> Arquivos
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-slate-400 mb-2">Arquivo Principal (PDF)</label>
                        <div class="border-2 border-dashed border-slate-700 rounded-lg p-6 text-center hover:border-indigo-500 transition cursor-pointer relative group">
                            <input type="file" name="file" accept="application/pdf" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="space-y-2">
                                <i class="fa-duotone fa-file-pdf text-4xl text-slate-500 group-hover:text-indigo-400 transition"></i>
                                <p class="text-sm text-slate-400 font-medium group-hover:text-white">Clique ou arraste o PDF aqui</p>
                                <p class="text-xs text-slate-600">Max: 10MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Image -->
                    <div x-data="{ previewUrl: null }">
                        <label class="block text-sm font-medium text-slate-400 mb-2">Capa / Preview (Imagem)</label>
                        <div class="border-2 border-dashed border-slate-700 rounded-lg p-6 text-center hover:border-indigo-500 transition cursor-pointer relative group h-40 flex flex-col items-center justify-center overflow-hidden">
                            <input type="file" name="preview_image" accept="image/*" @change="previewUrl = URL.createObjectURL($event.target.files[0])" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                            <template x-if="!previewUrl">
                                <div class="space-y-2">
                                    <i class="fa-duotone fa-image text-4xl text-slate-500 group-hover:text-indigo-400 transition"></i>
                                    <p class="text-sm text-slate-400 font-medium group-hover:text-white">Upload da Capa</p>
                                </div>
                            </template>

                            <template x-if="previewUrl">
                                <img :src="previewUrl" class="absolute inset-0 w-full h-full object-cover">
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('library.index') }}" class="px-6 py-3 text-slate-400 hover:text-white transition">Cancelar</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-lg font-bold shadow-lg shadow-indigo-900/50 transition transform hover:-translate-y-1">
                    Publicar Material
                </button>
            </div>
        </form>
    </div>
</x-core::layouts.master>
