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
        'componente',
        'ano_faixa',
        'unidade_tematica',
        'objeto_conhecimento',
        'objetos_conhecimento',
        'componente_curricular'
    ];

    protected $casts = [
        'codigo' => 'string',
        'objetos_conhecimento' => 'array',
    ];
}
