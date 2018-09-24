@component('layouts.dashboard')
  <div class="w-1/2">
    @foreach($cars as $car)
      <div class="bg-white flex">
        <div class="w-48 h-32">
          <img src="{{ $car->pivot->img_path }}" alt="Car image" class="w-48 h-32">
        </div>
        <div class="p-4">
          <div>{{ $car->make }} {{ $car->model }}</div>
          <div class="mt-2 text-xl">
            <a href="{{ route('cars.edit', ['car_id' => $car->id]) }}">
              <i class="fas fa-pencil-alt text-brand hover:text-brand-darker"></i>
            </a>
          </div>
        </div>
      </div>
    @endforeach

    <div class="float-right mt-4">
      <a href="{{ route('cars.create') }}" class="no-underline btn">
        Add new car
      </a>
    </div>
  </div>
@endcomponent
