@extends('layouts.app')

@php
  $sCity = app('request')->input('fc');
  $dCity = app('request')->input('dc');
  $count = $rides->total();
@endphp

@section('content')
  <div class="w-full md:w-5/6 lg:w-4/5 xl:w-1/2 mx-auto">
    <div>
      <span>{{ $count }}</span>
      {{ str_plural('ride', $count) }} available
      @if ($sCity) <span>from {{ $sCity }}</span> @endif
      @if ($dCity) <span>to {{ $dCity }}</span> @endif
    </div>

    @each('search._card', $rides, 'ride')

    <div class="flex justify-center my-6">
      {{ $rides->appends($_GET)->links() }}
    </div>
  </div>
@stop

@section('js')
  <script>
    function visitLink (ride) {
      let uri = `/rides/${ride.id}`
      let destinationCityName = (new URL(document.location)).searchParams.get('dc')

      if(destinationCityName === ride.destination_city.name) {
        return window.location.href = uri
      }

      let enrouteCity = ride.enroute_cities.find(c => c.city.name === destinationCityName)

      if (enrouteCity != null) {
        return window.location.href = `${uri}/${enrouteCity.order_from_source}`
      }

      return window.location.href = uri
    }
  </script>
@stop
