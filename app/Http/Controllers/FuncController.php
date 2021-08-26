<?php

namespace App\Http\Controllers;

use App\Models\Db as ModelsDb;
use App\Models\Func;
use App\Models\FuncParam;
use App\Models\Ns;
use App\Statics\FieldType;
use App\Statics\FunctionType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            abort(404);
        }
        $model = new Func();
        $model->name = $request->name;
        $model->type = $request->type;
        $model->is_public = $request->is_public;
        $model->timeout = $request->timeout;
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
        return redirect()->intended(route('function.show', ['func' => $model->id]));
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
        $options = [];
        $activeProject = Session::get('active_project');
        if ($func->type == FunctionType::TYPE_DB) {
            $options['databases'] = ModelsDb::where('project_id', '=', $activeProject->id)->get();
        }
        return Inertia::render('Function/Definition', [
            'func' => $func,
            'options' => $options
        ]);
    }
    public function definitionStore(Func $func, Request $request)
    {
        $func->config = $request->config;
        $func->save();
        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => ''
            ]
        );

        return redirect()->intended(route('function.definition', ['func' => $func->id]));
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
                abort(404);
            }
            $funcParam->function()->associate($func);
        }
        $funcParam->name = $request->name;
        $funcParam->default = $request->default;
        $funcParam->dir_type = $request->dir_type;
        $funcParam->value_type = $request->value_type;
        $funcParam->is_required = $request->is_required;
        $funcParam->path = $request->path;
        $funcParam->parent_id = $request->parent_id;
        $funcParam->is_assignable = $request->is_assignable;
        $funcParam->formula = $request->formula;
        $funcParam->save();

        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => ''
            ]
        );

        return redirect()->intended(route('function.parameters', ['func' => $funcParam->function->id]));
    }

    public function parameterDelete(?FuncParam $funcParam, Request $request)
    {
        if (empty($funcParam) || !$funcParam->exists) {
            abort(404);
        }
        $funcParam->delete();

        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_delete')
            ]
        );

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
        $types = [];
        foreach (FunctionType::labels() as $type => $label) {
            $types[] = ['type' => $type, 'label' => $label];
        }

        $activeProject = Session::get('active_project');
        $namespaces = Ns::where('project_id', '=', $activeProject->id)->get();
        return Inertia::render('Function/Edit', ['item' => $func, 'types' => $types, 'namespaces' => $namespaces]);
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
        $ns = Ns::find($request->namespace_id);
        if (empty($ns)) {
            abort(404);
        }
        $func->name = $request->name;
        $func->type = $request->type;
        $func->is_public = $request->is_public;
        $func->timeout = $request->timeout;
        $func->ns()->associate($ns);
        $func->save();

        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_update')
            ]
        );
        return redirect()->intended(route('function.show', ['func' => $func->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Func  $func
     * @return \Illuminate\Http\Response
     */
    public function destroy(Func $func)
    {
        DB::transaction(function () use ($func) {
            $func->params()->delete();
            $func->delete();
        });

        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_delete')
            ]
        );
        return redirect()->intended(route('function.index'));
    }
}
