{{ csrf_field() }}

<div class="form-input">
  <label for="make">Make</label>
  <input
    name="make"
    id="make"
    type="text"
    value="{{ old('make', $car->make) }}"
  >
  {!! $errors->first('make', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
</div>

<div class="form-input">
  <label for="model">Model</label>
  <input
    name="model"
    id="model"
    type="text"
    value="{{ old('model', $car->model) }}"
  >
  {!! $errors->first('model', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
</div>

<div class="form-input">
  <label for="year">Year</label>
  <input
    name="year"
    id="year"
    type="text"
    value="{{ old('year', $car->year) }}"
  >
  {!! $errors->first('year', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
</div>

<div class="form-input">
  <label for="registration_number">Registration number</label>
  <input
    name="registration_number"
    id="registration_number"
    type="text"
    value="{{ old('registration_number', $car->carUser ? $car->carUser->registration_number : null) }}"
  >
  {!! $errors->first('registration_number', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
</div>

<div class="form-input">
  <label for="img">Car picture</label>
  <div><input type="file" accept="image/*" id="img" name="img"></div>
  {!! $errors->first('img', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
</div>

<button type="submit" class="btn">
  {{ $btnText ?? 'Add' }}
</button>
