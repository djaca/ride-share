@component('layouts.dashboard')
  <div class="flex">
    <div class="">
      <form method="POST" action="{{ route('preferences.store') }}">
        {{ csrf_field() }}

        <table class="no-border">
          <tbody>
          <tr>
            <td><label class="text-sm text-grey-dark" for="dialog_allowed">I love quite drive</label></td>
            <td>
              <div class="form-switch inline-block align-middle">
                <input
                  type="checkbox"
                  name="dialog_allowed"
                  id="dialog_allowed"
                  class="form-switch-checkbox"
                  {{ $preference->dialog_allowed ? 'checked' : '' }}
                >
                <label class="form-switch-label" for="dialog_allowed"></label>
              </div>
            </td>
            <td><label class="text-sm text-grey-dark" for="dialog_allowed">I love to talk</label></td>
          </tr>
          <tr>
            <td><label class="text-sm text-grey-dark" for="smoking_allowed">No smoking please</label></td>
            <td>
              <div class="form-switch inline-block align-middle">
                <input
                  type="checkbox"
                  name="smoking_allowed"
                  id="smoking_allowed"
                  class="form-switch-checkbox"
                  {{ $preference->smoking_allowed ? 'checked' : '' }}
                >
                <label class="form-switch-label" for="smoking_allowed"></label>
              </div>
            </td>
            <td><label class="text-sm text-grey-dark" for="smoking_allowed">Smoking doesn`t bother me</label></td>
          </tr>
          <tr>
            <td><label class="text-sm text-grey-dark" for="pet_allowed">No pets please</label></td>
            <td><div class="form-switch inline-block align-middle">
                <input
                  type="checkbox"
                  name="pet_allowed"
                  id="pet_allowed"
                  class="form-switch-checkbox"
                  {{ $preference->pet_allowed ? 'checked' : '' }}
                >
                <label class="form-switch-label" for="pet_allowed"></label>
              </div></td>
            <td><label class="text-sm text-grey-dark" for="pet_allowed">Pets are most welcomed</label></td>
          </tr>
          <tr>
            <td><label class="text-sm text-grey-dark" for="music_allowed">Silence is golden</label></td>
            <td>
              <div class="form-switch inline-block align-middle">
                <input
                  type="checkbox"
                  name="music_allowed"
                  id="music_allowed"
                  class="form-switch-checkbox"
                  {{ $preference->music_allowed ? 'checked' : '' }}
                >
                <label class="form-switch-label" for="music_allowed"></label>
              </div>
            </td>
            <td><label class="text-sm text-grey-dark" for="music_allowed">Music is always on</label></td>
          </tr>
          </tbody>
        </table>

        <div>
          <button class="btn">Save</button>
        </div>
      </form>
    </div>
  </div>
@endcomponent
