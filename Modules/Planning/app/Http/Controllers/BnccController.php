<?php

namespace Modules\Planning\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BnccController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('planning::bncc.index');
    }
}
