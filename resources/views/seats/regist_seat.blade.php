@extends('layouts.simple')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('座席登録') }}</h1>
    </div>
    @include('partials.statusbar')
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>座席の登録が完了しました。</h4>
            </div>
            <div class="card-body">
                <p>以下の情報を登録しました。登録された情報が正しいかどうかを確認してください。</p>
                <x-form-element name="name" label="建物名称" value="{{ $seat->room->building->name ?? '' }}" />
                <x-form-element name="room_name" label="教室名称" value="{{ $seat->room->name ?? '' }}" />
                <x-form-element name="full_location" label="座席位置" value="{{ $seat->full_location ?? '' }}" />
                <x-form-element name="registerar" label="登録者" value="{{ $user->name }}（{{ $user->ocuid }}）" />
                <x-form-element name="time" label="登録時刻" value="{{ $record->created_at }}" />
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@endpush
