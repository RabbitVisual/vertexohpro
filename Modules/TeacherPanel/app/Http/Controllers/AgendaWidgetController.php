<?php

namespace Modules\TeacherPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendaWidgetController extends Controller
{
    /**
     * Get today's class schedule.
     */
    public function index()
    {
        // Mock data - in real app would fetch from Planning/ClassRecord module
        return response()->json([
            [
                'time' => '08:00',
                'class' => '6º Ano A',
                'subject' => 'Matemática',
                'room' => 'Sala 12',
                'color' => 'indigo'
            ],
            [
                'time' => '10:00',
                'class' => '7º Ano B',
                'subject' => 'Geometria',
                'room' => 'Sala 08',
                'color' => 'amber'
            ]
        ]);
    }
}
