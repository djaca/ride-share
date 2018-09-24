@extends('layouts.app')

@section('content')
  <div class="w-5/6 sm:w-1/2 md:w-2/5 lg:w-1/3 xl:w-1/4 mx-auto">
    <form method="POST" action="{{ route('offer.step.one') }}">
      {{ csrf_field() }}

      <div class="border mb-8">
        <div class="border-b">
          <div class="py-2 px-4 text-lg bg-brand-lighter">Pick-up & drop-off</div>
        </div>

        <div class="p-4">

          <div class="w-full my-2">
            <v-cities-autocomplete
              name="source_city_id"
              placeholder="Pick-up"
              value="id"
              old-value="{{ old('source_city_id') }}"
            ></v-cities-autocomplete>

            {!! $errors->first('source_city_id', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
          </div>

          <div class="w-full my-2">
            <v-cities-autocomplete
              name="destination_city_id"
              placeholder="Drop-off"
              value="id"
              old-value="{{ old('destination_city_id') }}"
            ></v-cities-autocomplete>
            {!! $errors->first('destination_city_id', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
          </div>

          <div class="mt-6">
            <enroute-cities
              name="enroute_city_id[]"
              placeholder="Stopovers"
              value="id"
              :multiple="true"
              old-value="{{ json_encode(old('enroute_city_id')) }}"
            ></enroute-cities>
          </div>

        </div>
      </div>

      <div class="border mb-8">
        <div class="border-b">
          <div class="py-2 px-4 text-lg bg-brand-lighter">Date & time</div>
        </div>

        <div class="p-4">
          <div class="form-input">
            <label for="time">Travel date</label>
            <input name="time" id="time" value="{{ old('time') }}">
            {!! $errors->first('time', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
          </div>
        </div>
      </div>

      <div class="float-right">
        <button type="submit" class="btn">Next</button>
      </div>
    </form>
  </div>
@stop

@section('js')
  <script>
    flatpickr('#time', {
      enableTime: true,
      dateFormat: 'Y-m-d H:i',
      minDate: 'today',
    })
  </script>
@stop
