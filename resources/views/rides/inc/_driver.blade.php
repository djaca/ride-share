<div class="border mt-4 p-4 flex">
  <div>
    <img src="{{ asset($driver->photo_path) }}" alt="{{ $driver->first_name }}" class="rounded-full w-16 h-16">
  </div>
  <div class="ml-4">
    <div class="mb-2">
      <a
        href="{{ route('public.profile', ['user_id' => $driver->id]) }}"
        class="no-underline text-brand-darker hover:underline"
      >
        {{ $driver->name }}
      </a>
    </div>
    @if($driver->years_old)
      <div class="mb-2">{{ $driver->years_old }} y/o</div>
    @endif

    @if($driver->preference)
    <div class="text-2xl flex justify-between">
      <div class="{{ $driver->preference->dialog_allowed ? 'text-brand-darker' : 'text-brand-lighter' }} border border-brand-light p-1 mr-1">
        <i class="far fa-comments"></i>
      </div>
      <div class="{{ $driver->preference->music_allowed ? 'text-brand-darker' : 'text-brand-lighter' }} border border-brand-light p-1 mx-1">
        <i class="fas fa-music"></i>
      </div>
      <div class="{{ $driver->preference->pet_allowed ? 'text-brand-darker' : 'text-brand-lighter' }} border border-brand-light p-1 mx-1">
        <i class="fas fa-paw"></i>
      </div>
      <div class="{{ $driver->preference->smoking_allowed ? 'text-brand-darker' : 'text-brand-lighter' }} border border-brand-light p-1 ml-1">
        <i class="fas fa-smoking"></i>
      </div>
    </div>
    @endif
  </div>
</div>
