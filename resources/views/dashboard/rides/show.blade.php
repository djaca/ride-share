@component('layouts.dashboard')
  <div class="md:flex">
    <div class="w-4/5 lg:w-2/5">
      <div>
        <table>
          <tbody>
          <tr>
            <td class="border-b-0">Pick-up point:</td>
            <td class="border-b-0">{{ $ride->sourceCity->name }}</td>
          </tr>
          <tr>
            <td class="border-b-0">Drop-off point:</td>
            <td class="border-b-0">{{ $ride->destinationCity->name }}</td>
          </tr>
          <tr>
            <td class="border-b-0">Date:</td>
            <td class="border-b-0">{{ $ride->getHumanReadableTime() }}</td>
          </tr>
          <tr>
            <td class="border-b-0">Price per seat:</td>
            <td class="border-b-0">${{ $ride->price_per_seat }}</td>
          </tr>
          @if(!$enrouteCities->isEmpty())
            <tr>
              <td class="border-b-0">Stopovers</td>
              <td class="border-b-0">
                @foreach($enrouteCities as $enrouteCity)
                  <div class="flex justify-between mb-2">
                    <div>{{ $enrouteCity->city->name }}</div>
                    <div>${{ $enrouteCity->prorated_price }}</div>
                  </div>
                @endforeach
              </td>
            </tr>
          @endif
          <tr>
            <td class="border-b-0">Seats left:</td>
            @if ($ride->seats_offered === 0)
              <td class="border-b-0">No seats left</td>
            @else
              <td class="border-b-0">{{ $ride->seats_offered }} {{ str_plural('seat', $ride->seats_offered) }}</td>
            @endif
          </tr>
          </tbody>
        </table>
      </div>
      @if($rideRequests->has('submitted'))
        <div class="mt-6">
          @foreach($rideRequests['submitted'] as $submittedRideRequest)
            <div class="border p-2 my-4">
              <div>
                <a
                  href="{{ route('public.profile', ['user_id' => $submittedRideRequest->requester->id]) }}"
                  class="no-underline hover:underline text-brand-dark"
                >
                  {{ $submittedRideRequest->requester->name }}</a> is requested ride to
                {{ $submittedRideRequest->enrouteCity
                  ? $submittedRideRequest->enrouteCity->city->name
                  : $ride->destinationCity->name }}.
              </div>

              <div class="mt-2 text-center">
                <form
                  method="POST"
                  action="{{ route('rides.requests.review', ['ride_request_id' => $submittedRideRequest->id]) }}"
                >

                  {{ csrf_field() }}

                  <button
                    type="submit"
                    name="status"
                    value="approve"
                    class="btn text-xs review"
                  >
                    Approve
                  </button>
                  <button
                    type="submit"
                    name="status"
                    value="reject"
                    class="btn text-xs review"
                  >
                    Reject
                  </button>
                </form>
              </div>
            </div>


          @endforeach
        </div>
      @endif
    </div>
    @if($rideRequests->has('approved'))
      <div>
        @foreach($rideRequests['approved'] as $approvedRideRequest)
          <div>
            <a href="#">{{ $approvedRideRequest->requester->name }}</a> is traveling to
            {{ $approvedRideRequest->enrouteCity ? $approvedRideRequest->enrouteCity->city->name : $ride->destinationCity->name }}
            .
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endcomponent
