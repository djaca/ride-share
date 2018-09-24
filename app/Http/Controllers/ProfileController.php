<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller
{
    /**
     * Show public profile.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $user->load('preference');

        $ridesCount = $user->rides()->count();

        return view('profile.show', compact('user', 'ridesCount'));
    }
}
