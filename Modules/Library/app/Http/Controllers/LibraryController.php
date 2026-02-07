<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display a listing of the authenticated user's purchased materials.
     * This serves as the "My Library" feature.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Retrieve materials purchased by the user, ordered by purchase date descending
        $purchasedMaterials = $user->purchasedMaterials()
            ->orderByPivot('purchased_at', 'desc')
            ->paginate(20);

        return response()->json($purchasedMaterials);
    }
}
