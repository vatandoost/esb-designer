<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = User::all();

        return Inertia::render('User/List', [
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
        return Inertia::render('User/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_admin' => 'boolean',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->is_admin,
            'password' => Hash::make($request->password),
        ]);

        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_create')
            ]
        );
        return redirect()->intended(route('user.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return Inertia::render('User/Edit', [
            'item' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('User/Edit', [
            'item' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'is_admin' => 'boolean',
            'email' => "required|string|email|max:255|unique:users,email," . $user->id,
        ];
        $fields = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->is_admin,
            'password' => Hash::make($request->password),
        ];
        if (!empty($request->password)) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        } else {
            unset($fields['password']);
        }
        $request->validate($rules);
        $user->update($fields);
        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_update')
            ]
        );
        return redirect()->intended(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        Session::flash(
            'toast_message',
            [
                'severity' => 'success',
                'summary' => __('messages.success'),
                'detail' => __('messages.success_delete')
            ]
        );
        return redirect()->intended(route('user.index'));
    }
}
