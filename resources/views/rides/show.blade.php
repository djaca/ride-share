@extends('layouts.app')

@section('content')
  <div class="w-3/4 lg:w-3/5 mx-auto">

    @include('rides.inc._cities')

    <div class="lg:flex lg:justify-between">
      <div class="w-full mb-4 lg:w-2/3 lg:mr-4">

        {{-- Ride details --}}
        <div class="border p-4">
          <table>
            <tbody>
            <tr>
              <td class="border-b-0">Pick-up point:</td>
              <td class="border-b-0">{{ $ride->sourceCity->name }}</td>
            </tr>
            <tr>
              <td class="border-b-0">Drop-off point:</td>
              <td class="border-b-0">
                @if($enrouteCitySelected)
                  {{ $enrouteCitySelected['name'] }}
                @else
                  {{ $ride->destinationCity->name }}
                @endif
              </td>
            </tr>
            <tr>
              <td class="border-b-0">Date:</td>
              <td class="border-b-0">{{ $ride->getHumanReadableTime() }}</td>
            </tr>
            </tbody>
          </table>
        </div>

        @include('rides.inc._driver')

        @include('rides.inc._car')
      </div>

      <div class="w-full lg:w-1/4">
        <div class="border">
          {{-- Price --}}
          <div class="border-b flex justify-between items-center p-4">
            <div class="text-xs">Price per seat</div>
            <div class="text-3xl">
              ${{ $enrouteCitySelected ? $enrouteCitySelected['price'] : $ride->price_per_seat }}
            </div>
          </div>

          @include('rides.inc._passengers')
        </div>

        @if($ride->time->isFuture())

          @if ($ride->hasAvailableSeats())
            @include('rides.inc._ride_request_form')
          @else
            <div class="p-4 text-sm">Ride does not have available seats left.</div>
          @endif

        @else
          <div class="p-4 text-sm">You can't book a ride that's already departed.</div>
        @endif
      </div>
    </div>
  </div>
@stop
