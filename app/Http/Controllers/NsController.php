<?php

namespace App\Http\Controllers;

use App\Models\Ns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class NsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeProject = Session::get('active_project');
        $items = Ns::where('project_id', '=', $activeProject->id)->get();

        return Inertia::render('Namespace/List', [
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
        return Inertia::render('Namespace/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ns = new Ns();
        $ns->name = $request->name;
        $activeProject = Session::get('active_project');
        $ns->project()->associate($activeProject);
        $ns->save();

        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_create')
            ]
        );
        return redirect()->intended(route('namespace.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ns  $ns
     * @return \Illuminate\Http\Response
     */
    public function show(Ns $ns)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ns  $ns
     * @return \Illuminate\Http\Response
     */
    public function edit(Ns $ns)
    {

        return Inertia::render('Namespace/Edit', [
            'item' => $ns
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ns  $ns
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ns $ns)
    {
        $ns->update($request->all());
        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_update')
            ]
        );
        return redirect()->intended(route('namespace.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ns  $ns
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ns $ns)
    {
        //
    }
}
