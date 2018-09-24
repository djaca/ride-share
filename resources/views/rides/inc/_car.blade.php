<div class="border mt-4">
  <div class="p-2 font-semibold">Car</div>
  <ul class="list-reset p-2">
    <li>{{ $car->make }} {{ $car->model }}</li>
    <li class="mt-3">
      <div class="w-32 h-32">
        <img src="{{ $ride->carUser->img_path }}" alt="">
      </div>
    </li>
  </ul>
</div>
