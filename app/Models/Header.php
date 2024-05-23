<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'tipo_registro',
        'cnpj',
        'identificador_emissor',
        'data_primeiro_registro',
        'data_ultimo_registro',
        'hora_primeiro_registro',
        'hora_ultimo_registro',
        'data_geracao',
        'periodo',
        'status',
        'data_envio_rm',
    ];

    public function detalhes()
    {
        return $this->hasMany(Detalhe::class);
    }

    public function trailler()
    {
        return $this->belongsTo(Trailler::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

}
