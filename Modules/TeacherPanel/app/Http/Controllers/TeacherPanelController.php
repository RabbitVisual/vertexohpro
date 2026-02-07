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
            'alunos-em-risco'
        ];

        $widgets = $settings ? $settings->widget_order : $defaultWidgets;

        // Ensure widgets is an array if for some reason it's null in DB
        if (!$widgets) {
             $widgets = $defaultWidgets;
        }

        return view('teacherpanel::index', compact('widgets'));
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
            'alunos-em-risco'
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
