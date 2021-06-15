<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; {{ env('APP_NAME') }}</title>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 ">
            <div class="login-brand">
              <img src="{{ asset('assets/img/oculogo.png') }}" alt="logo">
            </div>
            @if(session()->has('info'))
            <div class="alert alert-primary">
                {{ session()->get('info') }}
            </div>
            @endif
            @if(session()->has('status'))
            <div class="alert alert-info">
                {{ session()->get('status') }}
            </div>
            @endif
            @yield('content')
            <div class="simple-footer">
              Copyright &copy; 2020 大阪市立大学 学生システム構築プロジェクト</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <script src="{{ mix('js/manifest.js') }}"></script>
  <script src="{{ mix('js/vendor.js') }}"></script>
  <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
