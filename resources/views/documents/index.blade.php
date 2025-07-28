<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Documentos de Termo de Responsabilidade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Seus Termos Cadastrados</h3>
                        <a href="{{ route('documents.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Criar Novo Termo
                        </a>
                    </div>

                    {{-- Mensagens de Sucesso/Erro --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{-- Formulário de Filtros --}}
                    <form action="{{ route('documents.index') }}" method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="search_name" :value="__('Nome do Termo')" />
                                <x-text-input id="search_name" name="search_name" type="text" class="mt-1 block w-full" :value="request('search_name')" autofocus />
                            </div>
                            <div>
                                <x-input-label for="search_function" :value="__('Função do Usuário no Termo')" />
                                <x-text-input id="search_function" name="search_function" type="text" class="mt-1 block w-full" :value="request('search_function')" />
                            </div>
                            <div>
                                <x-input-label for="search_cpf" :value="__('CPF do Usuário no Termo')" />
                                <x-text-input id="search_cpf" name="search_cpf" type="text" class="mt-1 block w-full" :value="request('search_cpf')" />
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <x-primary-button>{{ __('Filtrar') }}</x-primary-button>
                            <a href="{{ route('documents.index') }}" class="ml-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Limpar Filtros') }}
                            </a>
                        </div>
                    </form>


                    @if ($documents->isEmpty())
                        <p class="mt-4 text-gray-600">Nenhum termo de responsabilidade encontrado.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome do Termo</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário no Termo</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Função no Termo</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF no Termo</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criado em</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($documents as $document)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $document->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $document->user_name_doc }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $document->user_role }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $document->user_document }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('documents.show', $document) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                                <a href="{{ route('documents.edit', $document) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                                    <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" aria-expanded="true">
                                                        Download
                                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                    <div x-show="open" @click.away="open = false"
                                                         x-transition:enter="transition ease-out duration-100"
                                                         x-transition:enter-start="transform opacity-0 scale-95"
                                                         x-transition:enter-end="transform opacity-100 scale-100"
                                                         x-transition:leave="transition ease-in duration-75"
                                                         x-transition:leave-start="transform opacity-100 scale-100"
                                                         x-transition:leave-end="transform opacity-0 scale-95"
                                                         class="origin-top-right absolute right-0 mt-2 w-32 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                                        <div class="py-1" role="none">
                                                            <a href="{{ route('documents.download', ['document' => $document->id, 'format' => 'docx']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">DOCX</a>
                                                            <a href="{{ route('documents.download', ['document' => $document->id, 'format' => 'pdf']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">PDF</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja remover este termo de responsabilidade?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-3">Remover</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $documents->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>