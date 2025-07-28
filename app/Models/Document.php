<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name_doc',
        'user_role',
        'user_document',
        'product_brand',
        'product_model',
        'product_serial_number',
        'product_processor',
        'product_memory',
        'product_disk',
        'product_price',
        'product_price_string',
        'local_doc',
        'date_doc',
        'accessories', // Mantenha este para a tabela dinâmica

        // Campos de metadados do documento no sistema
        'name',
        'file_path',
        'original_filename',
        'description',
    ];

    protected $casts = [
        'accessories' => 'array', // Converte o campo JSON para array automaticamente
        'date_doc' => 'date',     // Converte o campo de data para objeto Carbon
        'product_price' => 'decimal:2', // Garante que o preço seja formatado como decimal
    ];

    // Relação com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}