@component('layouts.dashboard')
  <div class="flex">
    <div class="w-1/3">
      <form method="POST" action="{{ route('cars.update', ['car_id' => $car->id]) }}" enctype="multipart/form-data">
        {{ method_field('PATCH') }}

        @include('dashboard.cars._form', ['btnText' => 'Update'])
      </form>
    </div>

    <div class="ml-4">
      <div class="w-48 h-48">
        <img src="{{ $car->carUser->img_path }}" alt="Car image">
      </div>
    </div>
  </div>
@endcomponent
