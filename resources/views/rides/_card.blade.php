<div class="lg:w-3/5 lg:mx-auto lg:px-2 xl:w-1/3 mb-2" onclick="window.location='/rides/{{ $ride->id }}'">
  <div class="bg-brand-lighter flex justify-between items-center cursor-pointer p-4 leading-normal">
    <div class="lg:w-3/5 text-xl lg:flex lg:flex-col lg:justify-between">
      <div>{{ $ride->sourceCity->name }}</div>
      <div>{{ $ride->destinationCity->name }}</div>
    </div>

    <div class="leading-tight">
      <div class="text-xs">{{ $ride->getHumanReadableTime(false) }}</div>
      <div class="text-3xl float-right">${{ $ride->price_per_seat }}</div>
    </div>
  </div>
</div>
