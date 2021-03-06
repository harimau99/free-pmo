<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

/**
 * User Profile Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('users.profile.show', compact('user'));
    }

    public function edit()
    {
        $langList = ['en' => trans('lang.en'), 'id' => trans('lang.id')];

        return view('users.profile.edit', compact('langList'));
    }

    public function update()
    {
        request()->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'lang'  => 'required|string|in:en,id',
        ]);

        $user = auth()->user();

        $user->name = request('name');
        $user->email = request('email');
        $user->lang = request('lang');
        $user->save();

        flash(trans('auth.profile_updated'), 'success');

        return redirect()->route('users.profile.show');
    }

    public function switchLang()
    {
        $userData = request()->validate([
            'lang' => 'required|string|in:en,id',
        ]);

        $user = request()->user();
        $user->lang = $userData['lang'];
        $user->save();

        return back();
    }
}
