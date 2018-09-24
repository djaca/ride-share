@php
  $tabs = ['active' => 'Upcoming rides', 'inactive' => 'Ride history'];
@endphp

@component('layouts.dashboard')
  <ul class="tabs">
    @foreach($tabs as $tabStatus => $text)
      <li>
        <a
          class="{{ $status == $tabStatus ? 'active' : 'hover:text-blue-darker' }}"
          href="{{ route('rides.offered.index', ['status' => $tabStatus]) }}"
        >
          {{ $text }}
        </a>
      </li>
    @endforeach
  </ul>

  @if($rides->isEmpty())
    <div class="mt-8">
      @if ($status === 'active')
        <div class="mb-2">You don't have any upcoming rides.</div>
      @else
        No rides in your ride history.
      @endif
    </div>
  @else
    <div>
      <table class="mt-8">
        <thead>
        <tr>
          <th>Travel date</th>
          <th>Route</th>
          <th>Available seats</th>
          <th>Price per seat</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($rides as $ride)
          <tr>
            <td>{{ $ride->getHumanReadableTime() }}</td>
            <td>
              <a
                href="{{ route('rides.show', ['ride_id' => $ride->id]) }}"
                class="no-underline hover:text-brand text-black"
              >
                {{ $ride->sourceCity->name }} - {{ $ride->destinationCity->name }}
              </a>
            </td>
            <td>{{ $ride->seats_offered }}</td>
            <td>${{ $ride->price_per_seat }}</td>
            <td><a href="{{ route('user.ride.show', ['ride_id' => $ride->id]) }}" class="btn no-underline">Details</a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>

      <div class="flex justify-center">
        {{ $rides->appends($_GET)->links() }}
      </div>

    </div>
  @endif

  <div class="mt-4">
    <a href="{{ route('offer.step.one') }}" class="btn no-underline">Offer a ride</a>
  </div>
@endcomponent
