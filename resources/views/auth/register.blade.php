@extends('layouts.app')

@section('content')
  <div class="flex items-center px-6 md:px-0">
    <div class="w-full max-w-md md:mx-auto">
      <div class="rounded shadow">
        <div class="font-medium text-lg text-brand-darker bg-brand p-3 rounded-t">
          Register
        </div>
        <div class="bg-white p-3 rounded-b">
          <form class="form-horizontal" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="flex items-stretch mb-3">
              <label for="first_name"
                     class="text-right font-semibold text-grey-dark text-sm pt-2 pr-3 align-middle w-1/4">First
                name</label>
              <div class="flex flex-col w-3/4">
                <input id="first_name" type="text"
                       class="flex-grow h-8 px-2 border rounded {{ $errors->has('name') ? 'border-red-dark' : 'border-grey-light' }}"
                       name="first_name" value="{{ old('first_name') }}" autofocus>
                {!! $errors->first('first_name', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
              </div>
            </div>

            <div class="flex items-stretch mb-3">
              <label for="last_name"
                     class="text-right font-semibold text-grey-dark text-sm pt-2 pr-3 align-middle w-1/4">Last
                name</label>
              <div class="flex flex-col w-3/4">
                <input id="last_name" type="text"
                       class="flex-grow h-8 px-2 border rounded {{ $errors->has('name') ? 'border-red-dark' : 'border-grey-light' }}"
                       name="last_name" value="{{ old('last_name') }}" autofocus>
                {!! $errors->first('last_name', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
              </div>
            </div>

            <div class="flex items-stretch mb-3">
              <label for="email" class="text-right font-semibold text-grey-dark text-sm pt-2 pr-3 align-middle w-1/4">E-Mail
                Address</label>
              <div class="flex flex-col w-3/4">
                <input id="email" type="email"
                       class="flex-grow h-8 px-2 border rounded {{ $errors->has('email') ? 'border-red-dark' : 'border-grey-light' }}"
                       name="email" value="{{ old('email') }}" required>
                {!! $errors->first('email', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
              </div>
            </div>

            <div class="flex items-stretch mb-4">
              <label for="password"
                     class="text-right font-semibold text-grey-dark text-sm pt-2 pr-3 align-middle w-1/4">Password</label>
              <div class="flex flex-col w-3/4">
                <input id="password" type="password"
                       class="flex-grow h-8 px-2 rounded border {{ $errors->has('password') ? 'border-red-dark' : 'border-grey-light' }}"
                       name="password" required>
                {!! $errors->first('password', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
              </div>
            </div>

            <div class="flex items-stretch mb-4">
              <label for="password_confirmation"
                     class="text-right font-semibold text-grey-dark text-sm pt-2 pr-3 align-middle w-1/4">Confirm
                Password</label>
              <div class="flex flex-col w-3/4">
                <input id="password_confirmation" type="password"
                       class="flex-grow h-8 px-2 rounded border {{ $errors->has('password_confirmation') ? 'border-red-dark' : 'border-grey-light' }}"
                       name="password_confirmation" required>
                {!! $errors->first('password_confirmation', '<span class="text-red-dark text-sm mt-2">:message</span>') !!}
              </div>
            </div>

            <div class="flex">
              <div class="w-3/4 ml-auto">
                <button type="submit"
                        class="bg-brand hover:bg-brand-dark text-white text-sm font-semibold py-2 px-4 rounded mr-3">
                  Register
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection