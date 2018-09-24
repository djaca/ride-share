<div class="flex text-2xl items-center mb-4">

  {{-- Source city --}}
  <div class="mr-2">{{ $ride->sourceCity->name }}</div>
  <i class="fas fa-long-arrow-alt-right text-lg text-brand-light"></i>

  {{-- Enroute cities --}}
  @if(count($enrouteCities))
    @foreach($enrouteCities as $eCity)
      <div class="mx-2">
        @if(!$enrouteCitySelected)
          <a
            href="{{ route('rides.show', ['ride_id' => $ride->id, 'enroute_city' => $eCity['order_from_source']]) }}"
            class="no-underline hover:underline text-brand text-base"
          >
            {{ $eCity['name'] }}
          </a>
        @else
          @if($enrouteCitySelected['order_from_source'] != $eCity['order_from_source'])
            <a
              href="{{ route('rides.show', ['ride_id' => $ride->id, 'enroute_city' => $eCity['order_from_source']]) }}"
              class="no-underline hover:underline text-brand text-base"
            >
              {{ $eCity['name'] }}
            </a>
          @else
            {{ $eCity['name'] }}
          @endif
        @endif
      </div>

      <i class="fas fa-long-arrow-alt-right text-lg text-brand-light"></i>
    @endforeach
  @endif

  {{-- Destination city --}}
  <div class="ml-2">
    @if(!$enrouteCitySelected)
      {{ $ride->destinationCity->name }}
    @else
      <a
        href="{{ route('rides.show', ['ride_id' => $ride->id]) }}"
        class="no-underline hover:underline text-brand text-base"
      >
        {{ $ride->destinationCity->name }}
      </a>
    @endif
  </div>

</div>
