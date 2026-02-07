<?php

namespace Modules\TeacherPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BnccWidgetController extends Controller
{
    /**
     * Search for BNCC skills.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        // Mock search logic
        // In real app, would query Planning module's BNCC table

        $skills = [
            ['code' => 'EF06MA01', 'description' => 'Comparar, ordenar, ler e escrever números naturais e números racionais...'],
            ['code' => 'EF06MA02', 'description' => 'Reconhecer o sistema de numeração decimal...'],
            ['code' => 'EF07MA01', 'description' => 'Resolver e elaborar problemas com números inteiros...'],
            ['code' => 'EF07MA02', 'description' => 'Resolver e elaborar problemas que envolvam porcentagens...'],
        ];

        if ($query) {
            $results = array_filter($skills, function($skill) use ($query) {
                return stripos($skill['code'], $query) !== false || stripos($skill['description'], $query) !== false;
            });
            return response()->json(array_values($results));
        }

        return response()->json([]);
    }
}
