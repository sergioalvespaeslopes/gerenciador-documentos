<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Termo: ') . $document->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Metadados do Sistema</h3>
                    <div class="mb-2">
                        <strong>Nome do Termo:</strong> {{ $document->name }}
                    </div>
                    <div class="mb-2">
                        <strong>Descrição:</strong> {{ $document->description ?? 'N/A' }}
                    </div>
                    <div class="mb-4">
                        <strong>Criado em:</strong> {{ $document->created_at->format('d/m/Y H:i') }}
                    </div>

                    <hr class="my-6">

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Dados do Termo (Preenchimento no DOCX)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <strong>Usuário no Termo:</strong> {{ $document->user_name_doc }}
                        </div>
                        <div>
                            <strong>Função:</strong> {{ $document->user_role }}
                        </div>
                        <div>
                            <strong>CPF:</strong> {{ $document->user_document }}
                        </div>
                        <div>
                            <strong>Marca do Notebook:</strong> {{ $document->product_brand }}
                        </div>
                        <div>
                            <strong>Modelo do Notebook:</strong> {{ $document->product_model }}
                        </div>
                        <div>
                            <strong>Nº de Série:</strong> {{ $document->product_serial_number }}
                        </div>
                        <div>
                            <strong>Processador:</strong> {{ $document->product_processor }}
                        </div>
                        <div>
                            <strong>Memória:</strong> {{ $document->product_memory }}
                        </div>
                        <div>
                            <strong>Disco Rígido:</strong> {{ $document->product_disk }}
                        </div>
                        <div>
                            <strong>Valor do Notebook:</strong> R$ {{ number_format($document->product_price, 2, ',', '.') }}
                        </div>
                        <div>
                            <strong>Valor por Extenso:</strong> {{ $document->product_price_string }}
                        </div>
                        <div>
                            <strong>Local de Assinatura:</strong> {{ $document->local_doc }}
                        </div>
                        <div>
                            <strong>Data de Assinatura:</strong> {{ $document->date_doc->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Acessórios e Periféricos Entregues</h3>
                        @if ($document->accessories && count($document->accessories) > 0)
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acessório</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($document->accessories as $accessory)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $accessory['name'] ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $accessory['quantity'] ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Nenhum acessório ou periférico cadastrado para este termo.</p>
                        @endif
                    </div>

                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('documents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Voltar para a Lista') }}
                        </a>
                        <a href="{{ route('documents.edit', $document) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Editar Termo') }}
                        </a>
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" aria-expanded="true">
                                Download
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 01-1.414 0l-4-4a1 1 010-1.414z" clip-rule="evenodd" />
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>