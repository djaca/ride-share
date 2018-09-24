@extends('layouts.app')

@section('content')
  <div class="w-5/6 sm:w-1/2 md:w-2/5 lg:w-1/3 xl:w-1/4 mx-auto">
    <form method="POST" action="{{ route('offer.step.two') }}">
      <div class="border mb-4">
        <div class="border-b p-3 bg-brand-lighter">Passenger contribution</div>
        {{ csrf_field() }}

        <div class="w-full px-4">
          @if($enrouteCities)
            @foreach($enrouteCities as $enrouteCity)
              <div class="text-lg font-semibold flex justify-between items-center my-4">
                <div>
                  {{ $ride->sourceCity->name }}
                  <i class="fas fa-arrow-right text-base"></i>
                  {{ $enrouteCity->city->name }}
                </div>

                <div class="w-1/4 flex items-center">
                  <span class="mr-1"><i class="fas fa-dollar-sign text-brand-dark"></i></span>
                  <div class="form-input mb-0">
                    <input
                      type="number"
                      name="enroute_price_per_seat[{{ $enrouteCity->city->name }}]"
                      value="{{ old("enroute_price_per_seat.{$enrouteCity->city->name}", $enrouteCity->prorated_price ?: 0) }}"
                    >
                  </div>
                </div>
              </div>
            @endforeach
            <div class="border-b"></div>
          @endif

          <div class="text-lg font-semibold flex justify-between items-center my-4">
            <div>
              {{ $ride->sourceCity->name }}
              <i class="fas fa-arrow-right text-base"></i>
              {{ $ride->destinationCity->name }}
            </div>

            <div class="w-1/4 flex items-center">
              <span class="mr-1"><i class="fas fa-dollar-sign text-brand-dark"></i></span>
              <div class="form-input mb-0">
                <input type="number" name="price_per_seat" value="{{ old('price_per_seat', $ride->price_per_seat ?: 0) }}">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-input mb-4">
        <label for="seats_offered">Number of seats</label>
        <input type="number" name="seats_offered" id="seats_offered" value="{{ old('seats_offered', 3) }}">
      </div>

      @if(!$errors->isEmpty())
        <div class="border border-red-light bg-red-lighter p-2 mb-4">
          @foreach($errors->all() as $error)
            <div class="py-1 text-brand-darkest">{{ $error }}</div>
          @endforeach
        </div>
      @endif

      <div class="float-right">
        <button type="submit" class="btn">Next</button>
      </div>
    </form>
  </div>
@stop
