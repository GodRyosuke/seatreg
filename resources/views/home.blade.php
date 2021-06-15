@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('ホーム') }}</h1>
    </div>
    @include('partials.statusbar')
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>ようこそ</h4>
            </div>
            <div class="card-body">
                <p>
                着席登録システムに関する情報を確認、登録することができます。左のメニューから選択してください。
                あなたのユーザ情報は次の通りです。
                </p>
            </div>
        </div>
        @include('users.userinfo')
        @include('users.rolemgr')
    </div>
</section>
@endsection
