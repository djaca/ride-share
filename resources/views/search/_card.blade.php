<div class="w-full border p-4 my-2 flex cursor-pointer hover:border-brand" onclick="visitLink({{ $ride }})">

  {{-- Avatar, left--}}
  <div class="w-1/4 lg:w-1/5 flex flex-col justify-center border-r hover:border-brand pr-6">
    <div class="w-full flex">
      <div class="w-12 h-12">
        <img src="{{ $ride->carUser->user->photo_path }}" alt="{{ $ride->carUser->user->name }}" class="w-12 h-12 rounded-full">
      </div>
      <div class="ml-2">
        <div class="text-xs my-2">{{ $ride->carUser->user->first_name }}</div>
        <div class="text-xs my-2">{{ $ride->carUser->user->years_old }} y/o</div>
      </div>
    </div>
  </div>

  {{-- middle--}}
  <div class="w-1/2 md:w-3/5 lg:flex-1">
    <div class="pl-2 h-full flex flex-col justify-around">
      <div>{{ $ride->getHumanReadableTime() }}</div>

      <div class="flex flex-wrap justify-start">
        <div class="pr-1">
          {{ $ride->sourceCity->name }}
        </div>

        @if(count($ride->enrouteCities))
          @foreach($ride->enrouteCities as $enrouteCity)
            <div class="px-2 {{ (app('request')->input('dc') == $enrouteCity->city->name) ? '' : 'text-brand' }}">
              {{ $enrouteCity->city->name }}
            </div>
          @endforeach
        @endif

        <div
          class="pl-1 {{ (app('request')->input('dc') == $ride->destinationCity->name) ? '' : 'text-brand' }}"
        >
          {{ $ride->destinationCity->name }}
        </div>
      </div>
    </div>
  </div>

  {{-- Price, right --}}
  <div class="w-1/4 lg:w-1/5 border-l hover:border-brand pl-2">
      <div class="text-2xl md:text-3xl">
        @if(app('request')->input('dc'))
          ${{
            app('request')->input('dc') == $ride->destinationCity->name
            ? $ride->price_per_seat
            : $ride->enrouteCities->findByName(app('request')->input('dc'))->prorated_price
          }}
        @else
          ${{ $ride->price_per_seat }}
        @endif
      </div>

    <div class="mb-4 text-sm md:text-base">per passenger</div>
    <div class="text-xs md:text-sm">
      <span class="font-semibold">{{ $ride->seats_offered }}</span> available seats
    </div>
  </div>
</div>
