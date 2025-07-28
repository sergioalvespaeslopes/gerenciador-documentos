<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Chave estrangeira para o usuário

            // Dados do termo de responsabilidade
            $table->string('user_name_doc');            // user_name (nome do usuário no documento)
            $table->string('user_role');                // user_role (função do usuário no documento)
            $table->string('user_document');            // user_document (CPF do usuário no documento)
            $table->string('product_brand');            // product_brand
            $table->string('product_model');            // product_model
            $table->string('product_serial_number');    // product_serial_number
            $table->string('product_processor');        // product_processor
            $table->string('product_memory');           // product_memory
            $table->string('product_disk');             // product_disk
            $table->decimal('product_price', 10, 2);    // product_price (valor numérico)
            $table->string('product_price_string');     // product_price_string (valor por extenso)
            $table->string('local_doc');                // local (local da assinatura)
            $table->date('date_doc');                   // date (data da assinatura)

            $table->json('accessories')->nullable();    // Para a tabela dinâmica de acessórios

            // Campos para metadados do documento no sistema
            $table->string('name');             // Nome do documento (como aparece na lista)
            $table->string('file_path');        // Caminho do arquivo original (Anexo1.docx)
            $table->string('original_filename'); // Nome do arquivo original
            $table->text('description')->nullable(); // Descrição opcional

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};