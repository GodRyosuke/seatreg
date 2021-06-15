@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('教室管理と座席情報') }}</h1>
    </div>

    <div class="section-body">
        @include('partials.statusbar')
        <p><a href="{{ route('rooms.create') }}" class="btn btn-primary">部屋情報の新規登録</a> </p>
        @include('rooms.list')
    </div>

</section>
@endsection

