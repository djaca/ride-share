@component('layouts.dashboard')
  <div>
    <div class="w-64">
      <div class="mb-8">
        <img src="{{ $user->photo_path }}" alt="{{ $user->name }}" class="rounded-full w-32 h-32">
      </div>

      <form method="POST" id="form" action="{{ route('photo.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" id="file" name="photo" accept="image/*" hidden>
        {!! $errors->first('photo', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}

        <button type="submit" class="btn" id="uploadBtn">
          Choose a file
        </button>
        <div class="text-xs mt-2">max. 3MB</div>
      </form>
    </div>
  </div>

@endcomponent

{{-- For now, leave it here... On page, it puts it down to bottom --}}
<script>
  document.getElementById('uploadBtn').onclick = e => {
    e.preventDefault()
    document.getElementById('file').click()
  }

  document.getElementById('file').onchange = e => {
    e.preventDefault()
    document.getElementById('form').submit()
  }
</script>

