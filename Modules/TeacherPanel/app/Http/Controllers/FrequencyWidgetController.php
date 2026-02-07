<?php

namespace Modules\TeacherPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrequencyWidgetController extends Controller
{
    /**
     * Get frequency data for the widget.
     */
    public function index()
    {
        // Mock data - in real app would fetch from ClassRecord module
        return response()->json([
            'labels' => ['Seg', 'Ter', 'Qua', 'Qui', 'Sex'],
            'data' => [60, 85, 45, 90, 75]
        ]);
    }
}
