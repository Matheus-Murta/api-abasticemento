<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RelacPermissoes extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'perfil_id',
        'permissao_id',
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    public function permissao()
    {
        return $this->belongsTo(Permissoes::class);
    }
}
