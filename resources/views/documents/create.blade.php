<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Novo Termo de Responsabilidade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                        @csrf

                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dados do Termo (Metadados do Sistema)</h3>
                        <div>
                            <x-input-label for="name" :value="__('Nome do Termo (para identificação no sistema)')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Descrição do Termo (opcional)')" />
                            <x-textarea id="description" class="block mt-1 w-full" name="description">{{ old('description') }}</x-textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <hr class="my-6">

                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dados para Preenchimento no DOCX (Usuário)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="user_name_doc" :value="__('Nome do Usuário no Termo')" />
                                <x-text-input id="user_name_doc" class="block mt-1 w-full" type="text" name="user_name_doc" :value="old('user_name_doc', Auth::user()->name)" required />
                                <x-input-error :messages="$errors->get('user_name_doc')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="user_role" :value="__('Função do Usuário no Termo')" />
                                <x-text-input id="user_role" class="block mt-1 w-full" type="text" name="user_role" :value="old('user_role')" required />
                                <x-input-error :messages="$errors->get('user_role')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="user_document" :value="__('CPF do Usuário no Termo (Ex: 123.456.789-00)')" />
                                <x-text-input id="user_document" class="block mt-1 w-full" type="text" name="user_document" :value="old('user_document')" required />
                                <x-input-error :messages="$errors->get('user_document')" class="mt-2" />
                            </div>
                        </div>

                        <hr class="my-6">

                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dados para Preenchimento no DOCX (Notebook)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="product_brand" :value="__('Marca do Notebook')" />
                                <x-text-input id="product_brand" class="block mt-1 w-full" type="text" name="product_brand" :value="old('product_brand')" required />
                                <x-input-error :messages="$errors->get('product_brand')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="product_model" :value="__('Modelo do Notebook')" />
                                <x-text-input id="product_model" class="block mt-1 w-full" type="text" name="product_model" :value="old('product_model')" required />
                                <x-input-error :messages="$errors->get('product_model')" class="mt-2" />
                            </div>
                            <div class="col-span-2">
                                <x-input-label for="product_serial_number" :value="__('Número de Série do Notebook')" />
                                <x-text-input id="product_serial_number" class="block mt-1 w-full" type="text" name="product_serial_number" :value="old('product_serial_number')" required />
                                <x-input-error :messages="$errors->get('product_serial_number')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <x-input-label for="product_processor" :value="__('Processador (Ex: Core i5 10ª Gen)')" />
                                <x-text-input id="product_processor" class="block mt-1 w-full" type="text" name="product_processor" :value="old('product_processor')" required />
                                <x-input-error :messages="$errors->get('product_processor')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="product_memory" :value="__('Memória (Ex: 8 GB)')" />
                                <x-text-input id="product_memory" class="block mt-1 w-full" type="text" name="product_memory" :value="old('product_memory')" required />
                                <x-input-error :messages="$errors->get('product_memory')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="product_disk" :value="__('Disco Rígido (Ex: 256 GB SSD)')" />
                                <x-text-input id="product_disk" class="block mt-1 w-full" type="text" name="product_disk" :value="old('product_disk')" required />
                                <x-input-error :messages="$errors->get('product_disk')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="product_price" :value="__('Valor do Notebook (R$)')" />
                            <x-text-input id="product_price" class="block mt-1 w-full" type="number" step="0.01" name="product_price" :value="old('product_price')" required />
                            <x-input-error :messages="$errors->get('product_price')" class="mt-2" />
                        </div>

                        <hr class="my-6">

                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dados para Preenchimento no DOCX (Assinatura)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="local_doc" :value="__('Local de Assinatura')" />
                                <x-text-input id="local_doc" class="block mt-1 w-full" type="text" name="local_doc" :value="old('local_doc', 'São Paulo')" required />
                                <x-input-error :messages="$errors->get('local_doc')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="date_doc" :value="__('Data de Assinatura')" />
                                <x-text-input id="date_doc" class="block mt-1 w-full" type="date" name="date_doc" :value="old('date_doc', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('date_doc')" class="mt-2" />
                            </div>
                        </div>

                        <hr class="my-6">

                        {{-- Acessórios e Periféricos (dinâmico) --}}
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Acessórios e Periféricos Entregues</h3>
                            <div id="accessories-container">
                                @if (old('accessories'))
                                    @foreach(old('accessories') as $index => $accessory)
                                        <div class="flex items-center space-x-2 mb-2 accessory-item">
                                            <x-text-input type="text" name="accessories[{{ $index }}][name]" placeholder="Nome do acessório" value="{{ $accessory['name'] ?? '' }}" class="flex-1" />
                                            <x-text-input type="number" name="accessories[{{ $index }}][quantity]" placeholder="Quantidade" value="{{ $accessory['quantity'] ?? '' }}" min="1" class="w-24" />
                                            <button type="button" onclick="removeAccessory(this)" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">Remover</button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" onclick="addAccessory()" class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Adicionar Acessório
                            </button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Cadastrar Termo') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let accessoryIndex = {{ old('accessories') ? count(old('accessories')) : 0 }};

            function addAccessory() {
                const container = document.getElementById('accessories-container');
                const div = document.createElement('div');
                div.classList.add('flex', 'items-center', 'space-x-2', 'mb-2', 'accessory-item');
                div.innerHTML = `
                    <x-text-input type="text" name="accessories[${accessoryIndex}][name]" placeholder="Nome do acessório" class="flex-1" />
                    <x-text-input type="number" name="accessories[${accessoryIndex}][quantity]" placeholder="Quantidade" min="1" class="w-24" />
                    <button type="button" onclick="removeAccessory(this)" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">Remover</button>
                `;
                container.appendChild(div);
                accessoryIndex++;
            }

            function removeAccessory(button) {
                button.closest('.accessory-item').remove();
            }
        </script>
    @endpush
</x-app-layout>