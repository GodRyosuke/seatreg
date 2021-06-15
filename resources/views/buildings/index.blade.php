@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('建物・エリア管理') }}</h1>
    </div>

    <div class="section-body">
        @include('partials.statusbar')
        <p><a href="{{ route('buildings.create') }}" class="btn btn-primary">建物・エリアの新規登録</a> </p>
        @include('buildings.list')
    </div>

</section>
@endsection

