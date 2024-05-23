<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalhe extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_id',
        'detalhe_tipo_registro',
        'numero_sequencial',
        'data_transacao',
        'valor_transacao',
        'numero_cartao',
        'qtd_material',
        'tipo_material',
        'servico',
        'tipo_abastecimento',
        'placa',
        'hodometro',
        'cnpj_estabelecimento',
        'nome_estabelecimento',
        'info1',
        'info2',
        'matricula_motorista',
    ];
}
