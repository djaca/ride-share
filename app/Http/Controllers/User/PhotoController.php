<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPhotoRequest;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = auth()->user();

        return view('dashboard.photo.show', compact('user'));
    }

    /**
     * @param \App\Http\Requests\AddPhotoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddPhotoRequest $request)
    {
        $user = auth()->user();
        $photo = $request->file('photo')
                         ->store('images/photos', 'public');

        Storage::disk('public')
               ->delete($user->getOriginal('photo_path'));

        $user->update(['photo_path' => $photo]);

        flash()->success('Photo updated successfully.');

        return back();
    }
}
