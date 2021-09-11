<?php

namespace App\Http\Controllers;

use App\Models\Db;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class DbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeProject = Session::get('active_project');
        $items = Db::where('project_id', '=', $activeProject->id)->get();

        return Inertia::render('Database/List', [
            'items' => $items,
            'types' => Db::types()
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
        foreach (Db::types() as $type => $label) {
            $types[] = ['type' => $type, 'label' => $label];
        }
        return Inertia::render('Database/Create', ['types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Db();
        $model->name = $request->name;
        $model->type = $request->type;
        $model->db = $request->db;
        $model->port = $request->port;
        $model->schema = $request->schema;
        $model->host = $request->host;
        $model->username = $request->username;
        $model->password = $request->password;
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
        return redirect()->intended(route('database.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Db  $db
     * @return \Illuminate\Http\Response
     */
    public function show(Db $db)
    {
        return Inertia::render('Database/Edit', [
            'item' => $db
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Db  $db
     * @return \Illuminate\Http\Response
     */
    public function edit(Db $db)
    {
        $types = [];
        foreach (Db::types() as $type => $label) {
            $types[] = ['type' => $type, 'label' => $label];
        }
        return Inertia::render('Database/Edit', [
            'item' => $db,
            'types' => $types
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Db  $db
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Db $db)
    {
        $db->update($request->all());
        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_update')
            ]
        );
        return redirect()->intended(route('database.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Db  $db
     * @return \Illuminate\Http\Response
     */
    public function destroy(Db $db)
    {
        $db->delete();
        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_delete')
            ]
        );
        return redirect()->intended(route('database.index'));
    }
}
