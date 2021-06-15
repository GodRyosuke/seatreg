@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('ユーザ管理') }}</h1>
    </div>

    <div class="section-body">
        @include('partials.statusbar')
        @yield($pagetype)  
    </div>
</section>
@endsection
