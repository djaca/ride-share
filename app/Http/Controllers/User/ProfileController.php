<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = auth()->user();

        return view('dashboard.profile.show', compact('user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        auth()->user()->update($request->all());

        flash()->success('Profile updated successfully.');

        return redirect()->route('profile');
    }
}
