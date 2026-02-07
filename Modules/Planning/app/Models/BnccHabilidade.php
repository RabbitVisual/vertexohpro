<?php

namespace Modules\Planning\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BnccHabilidade extends Model
{
    use HasFactory;

    protected $table = 'bncc_habilidades';

    protected $fillable = [
        'codigo',
        'descricao',
        'objetos_conhecimento',
        'ano_faixa',
        'componente_curricular'
    ];

    protected $casts = [
        'objetos_conhecimento' => 'array',
    ];
}
