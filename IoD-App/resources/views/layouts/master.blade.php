<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    @vite(['resources/scss/app.scss', 'resources/js/app.js', 'resources/css/our.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>

  <body class="o-bgcol">
    @include('layouts.header')
    @if(Session::get('success'))
      <div class="alert alert-success mx-5 mt-3">
        {{ Session::get('success') }}
      </div>
    @endif
    @if(Session::get('fail'))
        <div class="alert alert-danger">
          {{ Session::get('fail') }}
        </div>
    @endif
    @yield('content')
  </body>
  @include('layouts.footer')

</html>