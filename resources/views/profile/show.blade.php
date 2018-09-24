@extends('layouts.app')

@section('content')
  <div class="w-1/3 mx-auto">
    <div class="text-center mb-6">
      <img src="{{ asset($user->photo_path) }}" alt="{{ $user->first_name }}" class="w-24 h-24 rounded-full mb-4">
      <div class="text-2xl">{{ $user->first_name }}</div>
      <div class="text-2xl">{{ $user->years_old }} y/o</div>
    </div>


    @if ($user->preference)
      <div class="border-b mb-4"></div>

      <ul class="list-reset mb-4">
        <li class="py-2">{{ $user->preference->dialog() }}</li>
        <li class="py-2">{{ $user->preference->music() }}</li>
        <li class="py-2">{{ $user->preference->smoking() }}</li>
        <li class="py-2">{{ $user->preference->pet() }}</li>
      </ul>
    @endif

    @if ($user->hasVerifiedEmail())
      <div class="py-2">
        <i class="fas fa-check text-green"></i>
        Email verified
      </div>
    @endif

    @if ($user->phone)
      <div class="py-2">
        <i class="fas fa-check text-green"></i>
        Phone verified
      </div>
    @endif

    <div class="border-b my-4"></div>
    <div class="text-brand-darkest text-sm">
      <div class="py-2">{{ $ridesCount }} {{ str_plural('ride', $ridesCount) }} published</div>
      <div>Member since {{ $user->created_at->format('M Y') }}</div>
    </div>

  </div>
@stop
