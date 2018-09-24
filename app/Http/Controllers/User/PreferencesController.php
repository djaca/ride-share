<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Preference;
use Illuminate\Http\Request;

class PreferencesController extends Controller
{
    public function index()
    {
        $preference = auth()->user()->preference;

        if (!$preference) {
            $preference = Preference::make();
        }

        return view('dashboard.preferences.index', compact('preference'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $data = [
            'dialog_allowed' => $request->input('dialog_allowed') ? true : false,
            'music_allowed' => $request->input('music_allowed') ? true : false,
            'smoking_allowed' => $request->input('smoking_allowed') ? true : false,
            'pet_allowed' => $request->input('pet_allowed') ? true : false,
        ];

        if ($user->preference) {
            $user->preference()->update($data);
        }
        else {
            $user->preference()->create($data);
        }

        flash()->success('Preferences updated successfully.');

        return redirect()->back();
    }
}
