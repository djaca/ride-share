@extends('layouts.app')

@section('content')
  <div class="w-5/6 sm:w-2/3 md:w-1/2 lg:w-2/5 xl:w-1/3 mx-auto">
    <div class="border mb-4">
      <div class="border-b p-3 bg-brand-lighter">Confirm</div>

      <div class="mb-8">
        <table>
          <tbody>
          <tr>
            <td class="border-b-0">Pick-up point:</td>
            <td class="border-b-0">{{ $ride->sourceCity->name }}</td>
          </tr>
          <tr>
            <td class="border-b-0">Drop-off point:</td>
            <td class="border-b-0">
              {{ $ride->destinationCity->name }}

            </td>
          </tr>
          <tr>
            <td class="border-b-0">Date:</td>
            <td class="border-b-0">{{ $ride->getHumanReadableTime() }}</td>
          </tr>
          <tr>
            <td class="border-b-0">Price per seat:</td>
            <td class="border-b-0">${{ $ride->price_per_seat }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    @if($enrouteCities)
      <div class="border mb-4">
        <table>
          <tbody>
          <tr>
            <td class="border-b-0">Stopovers</td>
            <td class="border-b-0">
              @foreach($enrouteCities as $enrouteCity)
                <div class="flex justify-between">
                  <div class="p-2">{{ $enrouteCity->city->name }}</div>
                  <div class="p-2">${{ $enrouteCity->prorated_price }}</div>
                </div>
              @endforeach
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    @endif

    @if (auth()->user()->cars->isEmpty())
      <div class="border p-4">
        <form method="POST" action="{{ route('cars.store') }}" enctype="multipart/form-data">
          @include('dashboard.cars._form', ['car' => new \App\Car()])
        </form>
      </div>
    @else
      <form method="POST" action="{{ route('offer.step.three') }}">
        {{ csrf_field() }}

        <div class="border mb-4">
          <div class="p-4 flex justify-between items-center">
            <div class="w-1/3">Choose a car</div>

            <div class="form-input mb-0 flex-1">
              <div class="relative">
                <select name="car_user_id" class="bg-white">
                  @foreach(auth()->user()->cars as $car)
                    <option value="{{ $car->carUser->id }}">{{ $car->make }} {{ $car->model }}</option>
                  @endforeach
                </select>
                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-brand-darker">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="float-right">
          <button type="submit" class="btn">Confirm</button>
        </div>
      </form>
    @endif
  </div>
@stop
