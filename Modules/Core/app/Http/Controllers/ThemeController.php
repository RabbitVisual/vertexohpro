<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark,system',
        ]);

        $user = $request->user();
        $user->theme = $request->theme;
        $user->save();

        return response()->json(['status' => 'success']);
    }
}
