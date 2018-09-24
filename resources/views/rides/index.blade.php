@extends('layouts.app')

@section('content')
  <div class="w-3/4 mx-auto">
    @include('search._form')

    <div class="xl:flex xl:-mx-2 mb-8">
      @each('rides._card', $rides, 'ride')
    </div>

    <a href="{{ route('offer.step.one') }}" class="btn no-underline">Offer a ride</a>
  </div>
@stop

@section('js')
  <script>
    flatpickr('#date', {
      altInput: true,
      altFormat: "F j, Y",
      dateFormat: "Y-m-d",
      minDate: 'today',
    })
  </script>
@stop
