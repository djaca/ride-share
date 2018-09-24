@extends('layouts.app')

@section('content')
  <div class="w-4/5 lg:w-3/4 mx-auto lg:flex">
    <div class="flex-none w-full lg:max-w-xs mb-8 lg:mb-0">

      <div class="bg-grey p-2">Menu</div>

      <ul class="list-reset">
        <li class="p-1 hover:bg-grey-light">
          <a
            href="{{ route('dashboard') }}"
            class="no-underline text-black {{ Route::is('dashboard') ? 'text-blue' : null }}"
          >
            Dashboard
          </a>
        </li>

        <li class="p-1 hover:bg-grey-light">
          <a
            href="{{ route('profile') }}"
            class="no-underline text-black {{ Route::is('profile') ? 'text-blue' : null }}"
          >
            Profile
          </a>
        </li>

        <li class="p-1 hover:bg-grey-light">
          <a
            href="{{ route('photo') }}"
            class="no-underline text-black {{ Route::is('photo') ? 'text-blue' : null }}"
          >
            Photo
          </a>
        </li>

        <li class="p-1 hover:bg-grey-light">
          <a
            href="{{ route('preferences') }}"
            class="no-underline text-black {{ Route::is('preferences') ? 'text-blue' : null }}"
          >
            Preferences
          </a>
        </li>

        <li class="p-1 hover:bg-grey-light">
          <a
            href="{{ route('cars.index') }}"
            class="no-underline text-black {{ Route::is('cars.*') ? 'text-blue' : null }}"
          >
            Car
          </a>
        </li>

        <li class="p-1 hover:bg-grey-light">
          <a
            href="{{ route('rides.offered.index') }}"
            class="no-underline text-black {{ Route::is(['rides.offered.index', 'user.ride.show']) ? 'text-blue' : null }}"
          >
            Rides offered
          </a>
        </li>

        <li class="p-1 hover:bg-grey-light">
          <a
            href="{{ route('rides.booked.index') }}"
            class="no-underline text-black {{ Route::is('rides.booked.index') ? 'text-blue' : null }}"
          >
            Rides booked
          </a>
        </li>
      </ul>
    </div>

    <div class="flex-1 lg:ml-6">
      {{ $slot }}
    </div>
  </div>
@stop
