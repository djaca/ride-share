<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-brand-lightest h-screen">
<div id="app">
  <nav class="bg-white h-12 shadow mb-8 md:px-6 px-2">
    <div class="container mx-auto h-full">
      <div class="flex items-center justify-center h-12">
        <div class="mr-6">
          <a href="{{ url('/') }}" class="no-underline">
            {{ config('app.name', 'Laravel') }}
          </a>
        </div>
        <div class="flex-1 text-right">
          @guest
            <a class="no-underline hover:underline text-grey-darker pr-3 text-sm" href="{{ url('/login') }}">Login</a>
            <a class="no-underline hover:underline text-grey-darker text-sm" href="{{ url('/register') }}">Register</a>
          @else
            <a class="no-underline hover:underline text-grey-darker pr-3 text-sm" href="{{ route('dashboard') }}">
              {{ Auth::user()->first_name }}
            </a>

            <a href="{{ route('logout') }}"
               class="no-underline hover:underline text-grey-darker text-sm"
               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
              {{ csrf_field() }}
            </form>
          @endguest
        </div>
      </div>
    </div>
  </nav>

  @yield('content')

  <div style="right: 25px; bottom: 25px;" class="fixed">
   @if(session('flash_notification'))
      @foreach (session('flash_notification', collect())->toArray() as $message)
        <v-flash message="{{ json_encode($message) }}"></v-flash>
      @endforeach
   @else
    <v-flash></v-flash>
   @endif
  </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
</body>
</html>
