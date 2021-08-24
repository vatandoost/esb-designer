<?php

namespace App\Http\Controllers;

use App\Models\Func;
use App\Models\FuncParam;
use App\Models\Ns;
use App\Statics\FieldType;
use App\Statics\FunctionType;
use Illuminate\Database\Eloquent\Collection;
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
        $activeProject = Session::get('active_project');

        $namespaces = Ns::where('project_id', '=', $activeProject->id)->get();
        //$namespaces = $namespaces->map('id', 'name');
        $items = Func::whereIn('namespace_id', $namespaces->modelKeys())
            ->with('ns')
            ->get();
        return Inertia::render('Function/List', [
            'items' => $items,
            'types' => FunctionType::labels()
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
        $ns = Ns::find($request->namespace_id);
        if (empty($ns)) {
            // error
        }
        $model = new Func();
        $model->name = $request->name;
        $model->type = $request->type;
        $model->is_public = $request->is_public;
        $model->ns()->associate($ns);
        $model->save();

        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_create')
            ]
        );
        return redirect()->intended(route('function.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Func  $func
     * @return \Illuminate\Http\Response
     */
    public function show(Func $func)
    {
        $func->ns; // to load ns
        return Inertia::render('Function/View', [
            'func' => $func,
            'types' => FunctionType::labels()
        ]);
    }
    public function definition(Func $func)
    {
        return Inertia::render('Function/View', [
            'func' => $func,
            'params' => $func->params
        ]);
    }
    public function parameters(Func $func)
    {
        $fieldTypes = [];
        foreach (FieldType::labels() as $type => $label) {
            $fieldTypes[] = ['type' => $type, 'label' => $label];
        }
        return Inertia::render('Function/Parameters', [
            'func' => $func,
            'params' => $func->params,
            'fieldTypes' => $fieldTypes
        ]);
    }

    public function parameterSave(?FuncParam $funcParam, Request $request)
    {
        if (empty($funcParam) || !$funcParam->exists) {
            $funcParam = new FuncParam();
            $func = Func::find($request->function_id);
            if (empty($func) || !$func->exists) {
                //error
            }
            $funcParam->function()->associate($func);
        }
        $funcParam->name = $request->name;
        $funcParam->default = $request->default;
        $funcParam->dir_type = $request->dir_type;
        $funcParam->value_type = $request->value_type;
        $funcParam->is_assignable = $request->is_assignable;
        $funcParam->formula = $request->formula;
        $funcParam->save();

        return redirect()->intended(route('function.parameters', ['func' => $funcParam->function->id]));
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
