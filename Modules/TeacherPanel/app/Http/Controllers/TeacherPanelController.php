<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\TeacherPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\TeacherPanel\Models\TeacherPanelSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TeacherPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = TeacherPanelSetting::where('user_id', Auth::id())->first();

        $defaultWidgets = [
            'resumo-frequencia',
            'agenda-aulas',
            'atalhos-bncc',
            'marketplace-trends',
<<<<<<< HEAD
            'alunos-em-risco'
=======
            'alunos-em-risco',
            'notas-rapidas'
>>>>>>> origin/feature/teacher-panel-widgets-12290637904403310292
        ];

        $widgets = $settings ? $settings->widget_order : $defaultWidgets;

        // Ensure widgets is an array if for some reason it's null in DB
        if (!$widgets) {
             $widgets = $defaultWidgets;
        }

<<<<<<< HEAD
        return view('teacherpanel::index', compact('widgets'));
=======
        $notes = $settings ? $settings->notes : '';

        return view('teacherpanel::index', compact('widgets', 'notes'));
>>>>>>> origin/feature/teacher-panel-widgets-12290637904403310292
    }

    /**
     * Update the widget settings.
     */
    public function updateSettings(Request $request)
    {
        $allowedWidgets = [
            'resumo-frequencia',
            'agenda-aulas',
            'atalhos-bncc',
            'marketplace-trends',
<<<<<<< HEAD
            'alunos-em-risco'
=======
            'alunos-em-risco',
            'notas-rapidas'
>>>>>>> origin/feature/teacher-panel-widgets-12290637904403310292
        ];

        $request->validate([
            'widget_order' => 'required|array',
            'widget_order.*' => ['required', 'string', Rule::in($allowedWidgets)],
        ]);

        $settings = TeacherPanelSetting::updateOrCreate(
            ['user_id' => Auth::id()],
            ['widget_order' => $request->widget_order]
        );

        return response()->json([
            'message' => 'Configurações salvas com sucesso!',
            'settings' => $settings
        ]);
<<<<<<< HEAD
=======
    }

    /**
     * Update quick notes.
     */
    public function updateNotes(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        // Get current settings or create
        $settings = TeacherPanelSetting::firstOrCreate(
            ['user_id' => Auth::id()],
            ['widget_order' => [
                'resumo-frequencia',
                'agenda-aulas',
                'atalhos-bncc',
                'marketplace-trends',
                'alunos-em-risco',
                'notas-rapidas'
            ]]
        );

        $settings->notes = $request->notes;
        $settings->save();

        return response()->json([
            'message' => 'Notas salvas com sucesso!',
        ]);
>>>>>>> origin/feature/teacher-panel-widgets-12290637904403310292
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacherpanel::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('teacherpanel::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('teacherpanel::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
