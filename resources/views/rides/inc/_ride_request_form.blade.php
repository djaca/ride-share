@auth()
  @if (auth()->user()->id !== $driver->id)
    <div class="p-4 border my-4">
      <form
        method="POST"
        action="{{ route('requests.store', ['ride_id' => $ride->id]) }}"
      >
        {{ csrf_field() }}

        <div class="mb-4">
          <label for="privacy_policy" class="flex items-center block text-grey font-bold">
            <input class="mr-2 leading-tight" type="checkbox" name="privacy_policy" id="privacy_policy">
            <span class="text-xs">I accept the T&Cs and Privacy Policy.</span>
          </label>
          {!! $errors->first('privacy_policy', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
        </div>

        <input
          type="hidden"
          name="ride_id"
          value="{{ $ride->id }}"
        >

        @if($enrouteCitySelected)
          <input
            type="hidden"
            name="enroute_city_id"
            value="{{ $enrouteCitySelected->id }}"
          >
        @endif

        <button
          type="submit"
          class="btn w-full"
        >
          Make ride request
        </button>
      </form>
    </div>
  @endif
@endauth

@guest()
  <div class="p-4 text-center text-sm">
    Please <a href="{{ route('login') }}" class="no-underline hover:underline text-brand-darker">sign in</a> to make ride request
  </div>
@endguest
