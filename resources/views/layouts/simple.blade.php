<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title', 'Home') &mdash; {{ env('APP_NAME') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  @stack('stylesheet')
</head>

<body class="layout-3">
<div id="app">
  <div class="main-wrapper">
    <div class="login-brand">
      <img src="{{ asset('assets/img/oculogo.png') }}" alt="logo" width="250px" />
    </div>
 
    <!-- Main Content -->
    <div class="main-content">
      @yield('content')
    </div>
    <footer class="main-footer">
      @include('partials.footer')
    </footer>
  </div>
</div>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>

