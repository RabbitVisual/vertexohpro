<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        return view('classrecord::grades.index');
    }
}
