<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Statics\ProviderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ProviderController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeProject = Session::get('active_project');
        $items = Provider::where('project_id', '=', $activeProject->id)->get();

        return Inertia::render('Provider/List', [
            'items' => $items,
            'types' => ProviderType::labels()
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
        foreach (ProviderType::labels() as $type => $label) {
            $types[] = ['type' => $type, 'label' => $label];
        }
        return Inertia::render('Provider/Create', [
            'types' => $types
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
        $model = new Provider();
        $model->name = $request->name;
        $model->type = $request->type;
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
        return redirect()->intended(route('provider.edit', [
            'provider' => $model->id, 'activetab' => 1
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        return Inertia::render('Provider/Edit', [
            'item' => $provider
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider, Request $request)
    {
        $types = [];
        foreach (ProviderType::labels() as $type => $label) {
            $types[] = ['type' => $type, 'label' => $label];
        }
        return Inertia::render('Provider/Edit', [
            'item' => $provider,
            'types' => $types,
            'activetab' => +$request->query('activetab', 0)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provider $provider)
    {
        $provider->update($request->all());
        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_update')
            ]
        );
        return redirect()->intended(route('provider.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        $provider->delete();
        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_delete')
            ]
        );
        return redirect()->intended(route('provider.index'));
    }

}
