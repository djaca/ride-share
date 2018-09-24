<?php

namespace App\Http\Controllers\User;

use App\Car;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        $cars = auth()->user()->cars;

        if ($cars->isEmpty()) {
            request()->session()->reflash();

            return redirect()->route('cars.create');
        }

        return view('dashboard.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $car = new Car();

        return view('dashboard.cars.create', compact('car'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'make' => 'required',
            'model' => 'required',
            'year' => 'required',
            'registration_number' => 'required|unique:car_user',
            'img' => 'image'
        ]);

        $car = Car::create($request->only(['make', 'model', 'year']));

        auth()->user()
              ->cars()
              ->attach(
                  $car,
                  [
                      'registration_number' => $request->registration_number,
                      'img_path' => $request->img ? $request->file('img')->store('cars', 'public') : null
                  ]
              );

        flash()->success('Car successfully added.');

        return redirect()->route('cars.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Car $car
     *
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Car $car)
    {
        $this->authorize('update', $car);

        $car->load('carUser');

        return view('dashboard.cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Car                  $car
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);

        $request->validate([
            'make' => 'required',
            'model' => 'required',
            'year' => 'required',
            'registration_number' => 'required|unique:car_user,registration_number,' . $car->carUser->id,
            'img' => 'image'
        ]);

        $car->update($request->only(['make', 'model', 'year']));

        $this->updateCarUser($request, $car);

        flash()->success('Car updated successfully.');
        return redirect()->route('cars.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Car                 $car
     */
    private function updateCarUser(Request $request, Car $car)
    {
        if ($request->img) {
            Storage::disk('public')
                   ->delete($car->carUser->getOriginal('img_path'));

            $data = ['img_path' => $request->file('img')->store('cars', 'public')];
        }

        $data['registration_number'] = $request->registration_number;

        auth()->user()
              ->cars()
              ->updateExistingPivot($car->id, $data);
    }
}
