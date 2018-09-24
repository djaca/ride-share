@component('layouts.dashboard')
  <div class="w-1/3">
    <form method="POST" action="{{ route('profile.update', $user->id) }}">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}

      <div class="form-input">
        <label for="name">Name</label>
        <input
          name="name"
          id="name"
          type="text"
          value="{{ old('name', $user->name) }}"
        >
        {!! $errors->first('name', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
      </div>

      <div class="form-input">
        <label for="phone">Phone</label>
        <input
          name="phone"
          id="phone"
          type="text"
          value="{{ old('phone', $user->phone) }}"
        >
      </div>

      @php
        // Sets the top option to be the current year. (IE. the option that is chosen by default).
        $currently_selected = now()->subYears(18)->year;
        // Year to start available options at
        $earliest_year = now()->subCentury()->year;
        // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
        $latest_year = now()->year;
      @endphp

      <div class="form-input">
        <label for="year_of_birth">Year of birth</label>

        <div class="relative">
          <select name="year_of_birth">
            @foreach(range($latest_year, $earliest_year) as $year)
              <option value="{{ $year }}" {{ old('year_of_birth', $user->year_of_birth) == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endforeach
          </select>
          <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
            </svg>
          </div>
        </div>
      </div>

      <button type="submit" class="btn">
        Update
      </button>
    </form>
  </div>
@endcomponent
