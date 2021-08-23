<?php

namespace App\Http\Controllers;

use App\Models\Func;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FuncController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Func::all();
        return Inertia::render('Function/List', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Func  $func
     * @return \Illuminate\Http\Response
     */
    public function show(Func $func)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Func  $func
     * @return \Illuminate\Http\Response
     */
    public function edit(Func $func)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Func  $func
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Func $func)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Func  $func
     * @return \Illuminate\Http\Response
     */
    public function destroy(Func $func)
    {
        //
    }
}
