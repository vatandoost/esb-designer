<?php

namespace App\Http\Controllers;

use App\Models\Adapter;
use App\Models\Func;
use App\Models\Ns;
use App\Statics\AdapterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use PDO;

class AdapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeProject = Session::get('active_project');
        $items = Adapter::where('project_id', '=', $activeProject->id)->get();

        return Inertia::render('Adapter/List', [
            'items' => $items,
            'types' => AdapterType::labels()
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
        foreach (AdapterType::labels() as $type => $label) {
            $types[] = ['type' => $type, 'label' => $label];
        }
        $activeProject = Session::get('active_project');
        $namespaces = Ns::where('project_id', '=', $activeProject->id)->get()->keyBy('id')->toArray();
        $funcs = Func::select(['id', 'name', 'namespace_id'])
            ->whereIn('namespace_id', array_keys($namespaces))->get()->toArray();
        foreach ($funcs as &$func) {
            $func['name'] = $namespaces[$func['namespace_id']]['name'] . ' -> ' . $func['name'];
            unset($func['namespace_id']);
        }
        return Inertia::render('Adapter/Create', [
            'types' => $types,
            'funcs' => $funcs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Adapter();
        $model->name = $request->name;
        $model->type = $request->type;
        $model->function_id = $request->function_id;
        $activeProject = Session::get('active_project');
        $model->project()->associate($activeProject);
        $model->save();

        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_create')
            ]
        );
        return redirect()->intended(route('adapter.edit', [
            'adapter' => $model->id, 'activetab' => 1
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adapter  $adapter
     * @return \Illuminate\Http\Response
     */
    public function show(Adapter $adapter)
    {
        return Inertia::render('Adapter/Edit', [
            'item' => $adapter
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adapter  $adapter
     * @return \Illuminate\Http\Response
     */
    public function edit(Adapter $adapter, Request $request)
    {
        $types = [];
        foreach (AdapterType::labels() as $type => $label) {
            $types[] = ['type' => $type, 'label' => $label];
        }
        $activeProject = Session::get('active_project');
        $namespaces = Ns::where('project_id', '=', $activeProject->id)->get()->keyBy('id')->toArray();
        $funcs = Func::select(['id', 'name', 'namespace_id'])
            ->whereIn('namespace_id', array_keys($namespaces))->get()->toArray();
        foreach ($funcs as &$func) {
            $func['name'] = $namespaces[$func['namespace_id']]['name'] . ' -> ' . $func['name'];
            unset($func['namespace_id']);
        }
        return Inertia::render('Adapter/Edit', [
            'item' => $adapter,
            'types' => $types,
            'funcs' => $funcs,
            'activetab' => +$request->query('activetab', 0)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adapter  $adapter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Adapter $adapter)
    {
        $adapter->update($request->all());
        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_update')
            ]
        );
        return redirect()->intended(route('adapter.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adapter  $adapter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adapter $adapter)
    {
        $adapter->delete();
        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_delete')
            ]
        );
        return redirect()->intended(route('adapter.index'));
    }


    public function options(Func $func, $type)
    {
        $inputTypes = [];
        foreach (AdapterType::getInputTypes($type) as $key => $label) {
            $inputTypes[] = ['type' => $key, 'label' => $label];
        }
        $func->params;
        $options  = [
            'func' => $func,
            'inputTypes' => $inputTypes
        ];
        if ($type == AdapterType::TYPE_HTTP) {
            $options['methods'] = [
                ['label' => 'GET', 'code' => 'get'],
                ['label' => 'POST', 'code' => 'post'],
                ['label' => 'PUT', 'code' => 'put'],
                ['label' => 'DELETE', 'code' => 'delete'],
                ['label' => 'ANY', 'code' => 'any'],
            ];
            $options['requestTypes'] = [
                ['label' => 'JSON', 'code' => 'json'],
                ['label' => 'FORM', 'code' => 'form'],
            ];
            $options['responseTypes'] = [
                ['label' => 'JSON', 'code' => 'json'],
                ['label' => 'XML', 'code' => 'xml'],
                ['label' => 'Plain Text', 'code' => 'text'],
            ];
        }
        return $options;
    }
}
