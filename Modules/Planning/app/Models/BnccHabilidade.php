<?php

namespace Modules\Planning\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BnccHabilidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'descricao',
        'componente',
        'ano_faixa',
        'unidade_tematica',
        'objeto_conhecimento',
    ];

    protected $casts = [
        'codigo' => 'string',
    ];
}
