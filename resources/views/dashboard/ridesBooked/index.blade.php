@php
  $tabs = ['active' => 'Current', 'inactive' => 'History'];
@endphp

@component('layouts.dashboard')
  <ul class="tabs">
    @foreach($tabs as $tabStatus => $text)
      <li>
        <a
          class="{{ $status == $tabStatus ? 'active' : 'hover:text-blue-darker' }}"
          href="{{ route('rides.booked.index', ['status' => $tabStatus]) }}"
        >
          {{ $text }}
        </a>
      </li>
    @endforeach
  </ul>

  @if ($ridesRequests->isEmpty())
    <div class="mt-8">
      @if($status === 'active')
        See your current bookings here. Bookings on old rides can be found under History.
      @else
        See your bookings on old rides here.
      @endif
    </div>
  @else
    <table class="mt-8">
      <thead>
      <tr>
        <th>Travel date</th>
        <th>Pick-up city</th>
        <th>Drop-off city</th>
        <th>Driver</th>
        <th>Status</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      @foreach($ridesRequests as $rideRequest)
        <tr>
          <td>{{ $rideRequest->ride->time->toDateTimeString() }}</td>
          <td>{{ $rideRequest->ride->sourceCity->name }}</td>
          <td>
            {{ $rideRequest->enrouteCity ? $rideRequest->enrouteCity->city->name : $rideRequest->ride->destinationCity->name }}
          </td>
          <td>{{ $rideRequest->ride->carUser->user->name }}</td>
          <td>{{ $rideRequest->status }}</td>
          <td>
            <a
              href="{{ route('rides.show', ['ride_id' => $rideRequest->ride->id, 'enroute_city_id' => $rideRequest->enrouteCity ? $rideRequest->enrouteCity->id : null ]) }}"
              class="btn no-underline"
            >
              View
            </a>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>

    <div class="flex justify-center">
      {{ $ridesRequests->appends($_GET)->links() }}
    </div>
  @endif
@endcomponent
