<?php

namespace App\Http\Controllers;

use App\Models\Func;
use App\Models\Ns;
use App\Statics\FunctionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
        $types = [];
        foreach (FunctionType::labels() as $type => $label) {
            $types[] = ['type' => $type, 'label' => $label];
        }
        $activeProject = Session::get('active_project');
        $namespaces = Ns::where('project_id', '=', $activeProject->id)->get();
        return Inertia::render('Function/Create', ['types' => $types, 'namespaces' => $namespaces]);
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
