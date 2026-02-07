<?php

namespace Modules\Library\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Library\Models\Material;

class LibraryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            'Plano de Aula - Sistema Solar',
            'Atividade de Frações - 6º Ano',
            'Projeto Leitura e Escrita',
            'Dinâmica de Grupo - Boas Vindas',
            'Mapa Mental - Revolução Francesa',
            'Exercícios de Equação 1º Grau',
            'Apostila de Redação ENEM',
            'Jogo da Memória - Tabuada',
        ];

        foreach ($materials as $title) {
            Material::create([
                'title' => $title,
                'downloads_count' => rand(10, 500),
            ]);
        }
    }
}
