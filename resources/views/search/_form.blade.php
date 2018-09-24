<form method="GET" action="{{ route('search') }}">
  <div class="lg:flex lg:justify-between mb-8">
    <div class="lg:flex lg:-mx-3 lg:w-5/6">
      <div class="px-3 w-full lg:w-1/3 mb-1 lg:mb-0">
        <v-cities-autocomplete
          name="fc"
          placeholder="Leaving from..."
          value="name"
        ></v-cities-autocomplete>
      </div>

      <div class="px-3 w-full lg:w-1/3 mb-1 lg:mb-0">
        <v-cities-autocomplete
          name="dc"
          placeholder="Going to..."
          value="name"
        ></v-cities-autocomplete>
      </div>

      <div class="form-input px-3 w-full lg:w-1/3 mb-1 lg:mb-0">
        <input name="date" id="date" value="{{ old('date') }}" placeholder="Date">
        {!! $errors->first('date', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
      </div>
    </div>

    <div class="flex justify-center">
      <button type="submit" class="btn">
        Find a ride
      </button>
    </div>
  </div>
</form>
