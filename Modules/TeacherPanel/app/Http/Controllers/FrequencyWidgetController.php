<?php

namespace Modules\TeacherPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FrequencyWidgetController extends Controller
{
    /**
     * Get frequency data for the widget.
     */
    public function index()
    {
        // Fetch attendance for the last 5 days
        $startDate = Carbon::now()->subDays(5);

        $attendanceData = Attendance::select('date',
                DB::raw('count(*) as total'),
                DB::raw("sum(case when status = 'present' then 1 else 0 end) as present_count")
            )
            ->where('date', '>=', $startDate->format('Y-m-d'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $data = [];

        foreach ($attendanceData as $record) {
            $labels[] = Carbon::parse($record->date)->format('d/m');
            // Avoid division by zero
            $percentage = $record->total > 0 ? round(($record->present_count / $record->total) * 100) : 0;
            $data[] = $percentage;
        }

        // If no data, provide some defaults or empty arrays
        if (empty($labels)) {
             $labels = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex'];
             $data = [0, 0, 0, 0, 0];
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
