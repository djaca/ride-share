@component('layouts.dashboard')
  <div class="w-full">
    <div class="text-2xl mb-8">
      <i class="far fa-bell text-brand-darker text-xl"></i>
      Notifications
    </div>

    <ul class="list-reset notifications xl:w-2/3">
      {{-- Notification on ride request and answer on ride request auth user has requested --}}

      @if(!$rides->isEmpty())
        @foreach($rides as $ride)
          <li>
            <div class="mb-2">
              <div>
                You have {{ $ride->rideRequests->count() }} {{ str_plural('request', $ride->rideRequests->count()) }} for ride from {{ $ride->sourceCity->name }} to {{ $ride->destinationCity->name }}
              </div>
              <div>{{ $ride->getHumanReadableTime(false) }}</div>
              <div><a href="{{ route('user.ride.show', ['ride_id' => $ride->id]) }}">Details</a></div>
            </div>
          </li>
        @endforeach
      @endif

      @if(!$user->hasVerifiedEmail())
        @if(!session('resent'))
          <li>
            <div class="mb-2">Verify your email address</div>
            {{ __('If you did not receive the email') }},
            <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>
          </li>
        @endif
      @endif

      @if($user->cars->isEmpty())
        <li>
          <div class="mb-2">
            <a href="{{ route('cars.create') }}">Add your car</a>
          </div>

          <div>People like to know in what kind of car they will travel</div>
        </li>
      @endif

      @if(!$user->hasPhoto())
        <li>
          <div class="mb-2">
            <a href="{{ route('photo') }}">Add your photo</a>
          </div>

          <div>People like to put a face to a name</div>
        </li>
      @endif

      @if(!$user->phone)
        <li>
          <div class="mb-2">
            <a href="{{ route('profile') }}">Verify your phone number</a>
          </div>

          <div>People prefer to travel with others who have verified phone number</div>
        </li>
      @endif

      @if(!$user->year_of_birth)
        <li>
          <div class="mb-2">
            <a href="{{ route('profile') }}">Verify your birth year</a>
          </div>

          <div>People want to know your age</div>
        </li>
      @endif

      @if(!$user->preference)
        <li>
          <div class="mb-2">
            <a href="{{ route('preferences') }}">Add preference</a>
          </div>

          <div>People want to know your ride preferences</div>
        </li>
      @endif
    </ul>
  </div>
@endcomponent
