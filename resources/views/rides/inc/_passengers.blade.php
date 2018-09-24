<div class="p-4">
  <div class="text-center text-sm">Passengers on this ride</div>
  <div class="flex flex-wrap justify-center mt-2">
    @if(!$passengers->isEmpty())
      @foreach($passengers as $passenger)
        <div class="w-16 h-16 rounded-full mx-2 mb-6">
          <a href="{{ route('public.profile', ['user_id' => $passenger->id]) }}">
            <img src="{{ asset($passenger->photo_path) }}"
                 alt="{{ $passenger->first_name }}"
                 class="rounded-full w-16 h-16"
            >
          </a>
          <div class="text-xs text-center">{{ $passenger->first_name }}</div>
        </div>
      @endforeach
    @endif

    @for($i = 0; $i < $ride->seats_offered; $i++)
      <div class="w-16 h-16 border rounded-full mx-2 mb-2"></div>
    @endfor
  </div>

  <div class="text-center text-sm mt-6">
    <span class="font-semibold">{{ $ride->seats_offered }}</span>
    available {{ str_plural('seat', $ride->seats_offered) }}
  </div>
</div>
