<?php

namespace Modules\TeacherPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Library\Models\Material;

class MarketplaceTrendsWidgetController extends Controller
{
    /**
     * Get top downloaded materials.
     */
    public function index()
    {
        $trends = Material::orderBy('downloads_count', 'desc')
            ->take(5)
            ->get(['title', 'downloads_count']);

        return response()->json($trends);
    }
}
