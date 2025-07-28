<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str; // <-- Esta importação é necessária para Str::slug, por exemplo.



class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = auth()->user()->documents(); 

        if ($request->has('search_name') && $request->search_name != '') {
            $documents->where('name', 'like', '%' . $request->search_name . '%');
        }
        if ($request->has('search_function') && $request->search_function != '') {
            $documents->where('user_role', 'like', '%' . $request->search_function . '%');
        }
        if ($request->has('search_cpf') && $request->search_cpf != '') {
            $documents->where('user_document', 'like', '%' . $request->search_cpf . '%');
        }

        $documents = $documents->latest()->paginate(10);

        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_name_doc' => 'required|string|max:255',
            'user_role' => 'required|string|max:255',
            'user_document' => 'required|string|max:14', 
            'product_brand' => 'required|string|max:255',
            'product_model' => 'required|string|max:255',
            'product_serial_number' => 'required|string|max:255',
            'product_processor' => 'required|string|max:255',
            'product_memory' => 'required|string|max:255',
            'product_disk' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'local_doc' => 'required|string|max:255',
            'date_doc' => 'required|date',
            'accessories' => 'nullable|array',
            'accessories.*.name' => 'nullable|string',
            'accessories.*.quantity' => 'nullable|integer|min:1',
        ]);

        $productPriceString = "R$ " . number_format($request->product_price, 2, ',', '.') . " (valor numérico)";

        $document = auth()->user()->documents()->create([
            'name' => $request->name,
            'description' => $request->description,
            'user_name_doc' => $request->user_name_doc,
            'user_role' => $request->user_role,
            'user_document' => $request->user_document,
            'product_brand' => $request->product_brand,
            'product_model' => $request->product_model,
            'product_serial_number' => $request->product_serial_number,
            'product_processor' => $request->product_processor,
            'product_memory' => $request->product_memory,
            'product_disk' => $request->product_disk,
            'product_price' => $request->product_price,
            'product_price_string' => $productPriceString,
            'local_doc' => $request->local_doc,
            'date_doc' => $request->date_doc,
            'accessories' => $request->accessories,
            'file_path' => 'templates/Anexo1.docx', 
            'original_filename' => 'Anexo1.docx',
        ]);

        return redirect()->route('documents.index')->with('success', 'Documento cadastrado com sucesso!');
    }

    public function show(Document $document)
    {
        $this->authorize('view', $document);
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $this->authorize('update', $document);
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorize('update', $document);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_name_doc' => 'required|string|max:255',
            'user_role' => 'required|string|max:255',
            'user_document' => 'required|string|max:14', // CPF
            'product_brand' => 'required|string|max:255',
            'product_model' => 'required|string|max:255',
            'product_serial_number' => 'required|string|max:255',
            'product_processor' => 'required|string|max:255',
            'product_memory' => 'required|string|max:255',
            'product_disk' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'local_doc' => 'required|string|max:255',
            'date_doc' => 'required|date',
            'accessories' => 'nullable|array',
            'accessories.*.name' => 'nullable|string',
            'accessories.*.quantity' => 'nullable|integer|min:1',
        ]);

        $productPriceString = "R$ " . number_format($request->product_price, 2, ',', '.') . " (valor numérico)";

        $document->update([
            'name' => $request->name,
            'description' => $request->description,
            'user_name_doc' => $request->user_name_doc,
            'user_role' => $request->user_role,
            'user_document' => $request->user_document,
            'product_brand' => $request->product_brand,
            'product_model' => $request->product_model,
            'product_serial_number' => $request->product_serial_number,
            'product_processor' => $request->product_processor,
            'product_memory' => $request->product_memory,
            'product_disk' => $request->product_disk,
            'product_price' => $request->product_price,
            'product_price_string' => $productPriceString,
            'local_doc' => $request->local_doc,
            'date_doc' => $request->date_doc,
            'accessories' => $request->accessories,
        ]);

        return redirect()->route('documents.index')->with('success', 'Documento atualizado com sucesso!');
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        $document->delete(); 

        return redirect()->route('documents.index')->with('success', 'Documento removido com sucesso!');
    }

    public function download(Document $document, $format)
    {
        $this->authorize('download', $document);

        $templatePath = storage_path('app/public/' . $document->file_path);

        if (!Storage::disk('public')->exists('templates/Anexo1.docx')) {
            return back()->with('error', 'O arquivo de modelo (Anexo1.docx) não foi encontrado. Certifique-se de que ele está em storage/app/public/templates/');
        }

        try {
            $templateProcessor = new TemplateProcessor($templatePath);
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao carregar o template do documento: ' . $e->getMessage());
        }

        $templateProcessor->setValue('user_name', $document->user_name_doc);
        $templateProcessor->setValue('user_role', $document->user_role);
        $templateProcessor->setValue('user_document', $document->user_document);
        $templateProcessor->setValue('product_brand', $document->product_brand);
        $templateProcessor->setValue('product_model', $document->product_model);
        $templateProcessor->setValue('product_serial_number', $document->product_serial_number);
        $templateProcessor->setValue('product_processor', $document->product_processor);
        $templateProcessor->setValue('product_memory', $document->product_memory);
        $templateProcessor->setValue('product_disk', $document->product_disk);
        $templateProcessor->setValue('product_price', number_format($document->product_price, 2, ',', '.')); // Formata o valor
        $templateProcessor->setValue('product_price_string', $document->product_price_string);
        $templateProcessor->setValue('local', $document->local_doc);
        $templateProcessor->setValue('date', $document->date_doc->format('d/m/Y')); // Formata a data

        $accessories = $document->accessories;
        if (!empty($accessories)) {
            $templateProcessor->cloneRow('acessory_name', count($accessories)); 

            foreach ($accessories as $index => $accessory) {
                $templateProcessor->setValue('acessory_name#' . ($index + 1), $accessory['name'] ?? 'N/A');
                $templateProcessor->setValue('acessory_quantity#' . ($index + 1), $accessory['quantity'] ?? 'N/A');
            }
        } else {
            $templateProcessor->setValue('acessory_name', 'Nenhum acessório');
            $templateProcessor->setValue('acessory_quantity', '');
        }

        $outputFilename = 'Termo_Responsabilidade_' . uniqid() . '.docx';
        $outputPath = storage_path('app/public/generated_documents/' . $outputFilename);
        $templateProcessor->saveAs($outputPath);

        $downloadFilename = 'Termo_Responsabilidade_' . Str::slug($document->name) . '_' . date('Ymd_His');

        if ($format === 'pdf') {
            try {
                $phpWord = IOFactory::load($outputPath, 'Word2007');
                $pdfRenderer = IOFactory::createWriter($phpWord, 'PDF');
                $pdfOutputPath = storage_path('app/public/generated_documents/temp_pdf_' . uniqid() . '.pdf');
                $pdfRenderer->save($pdfOutputPath);

                Storage::disk('public')->delete('generated_documents/' . $outputFilename); // Deleta o DOCX temporário

                return response()->download($pdfOutputPath, $downloadFilename . '.pdf')->deleteFileAfterSend(true);
            } catch (\Exception $e) {
                return back()->with('error', 'Erro ao converter para PDF: ' . $e->getMessage() . '. Verifique se o PHP tem permissão de escrita e se a biblioteca GD ou ImageMagick está instalada para renderização de imagens no PDF. Formatos complexos de DOCX podem ter problemas na conversão para PDF.');
            }
        } elseif ($format === 'docx') {
            return response()->download($outputPath, $downloadFilename . '.docx')->deleteFileAfterSend(true);
        } else {
            return back()->with('error', 'Formato de download inválido. Escolha DOCX ou PDF.');
        }
    }
}