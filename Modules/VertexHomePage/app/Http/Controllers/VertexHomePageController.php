<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\VertexHomePage\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VertexHomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vertexhomepage::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vertexhomepage::create');
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
        return view('vertexhomepage::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('vertexhomepage::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    /**
     * Show the Terms of Service page.
     */
    public function terms()
    {
        return view('vertexhomepage::legal.terms');
    }

    /**
     * Show the Privacy Policy page.
     */
    public function privacy()
    {
        return view('vertexhomepage::legal.privacy');
    }

    /**
     * Show the contact page.
     */
    public function contact()
    {
        return view('vertexhomepage::contact');
    }

    /**
     * Show the about page.
     */
    public function about()
    {
        return view('vertexhomepage::about');
    }

    /**
     * Show the FAQ page.
     */
    public function faq()
    {
        return view('vertexhomepage::faq');
    }
}
