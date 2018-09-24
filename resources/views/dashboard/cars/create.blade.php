@component('layouts.dashboard')
  <div class="w-1/3">
    <form method="POST" action="{{ route('cars.store') }}" enctype="multipart/form-data">
      @include('dashboard.cars._form')
    </form>
  </div>
@endcomponent
