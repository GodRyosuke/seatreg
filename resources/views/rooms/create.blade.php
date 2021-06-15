@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('教室の登録と更新') }}</h1>
    </div>
    @include('partials.statusbar')
    <div class="section-body">
        <div class="card">
            <div class="card-header">
            @isset($room)
                <h4>更新</h4>
            @else
                <h4>新規登録</h4>
            @endisset
            </div>
            <div class="card-body">
                <form method="POST" action="@isset($room) {{ route('rooms.update', $room->id) }} @else {{ route('rooms.store') }} @endisset">
                @isset($room)
                    @method('PATCH')
                @endisset
                    @csrf
                    <x-form-element name="name" label="名称" value="{{ $room->name ?? '' }}" />
                    <x-form-element name="code" label="部屋コード" value="{{ $room->code ?? '' }}" />
                    <x-form-element type="option_assoc" name="building_id" value="{{ $room->building->id ?? '' }}"  label="部局名" :items="App\Building::all()->pluck('name', 'id')"/>
                    <x-form-element name="floor" label="階" value="{{ $building->floors ?? '' }}" />
                    <x-form-element name="rows" label="行数（縦）" value="{{ $room->rows ?? '' }}" />
                    <x-form-element name="cols" label="列数（横）" value="{{ $room->cols ?? '' }}" />
                    <x-form-element name="capacity" label="定員" value="{{ $room->capacity ?? '' }}" />
                    <x-form-element name="capacity_exam" label="定員（試験時）" value="{{ $room->capacity_exam ?? '' }}" />
                    <x-form-element name="capacity_covid" label="定員（コロナ）" value="{{ $room->capacity_covid ?? '' }}" />
                    <x-form-element name="creator" label="作成者" value="{{ $room->creator->name ?? '' }}" />                    
                    <x-form-element type="long" name="memo" label="メモ" value="{{ $room->memo ?? '' }}" />
                    <div class="card-footer text-right">
                        @isset($room)
                            <button type="submit" class="btn btn-danger">削除</button> &nbsp;
                            <button type="submit" class="btn btn-primary">更新</button>
                        @else
                            <button type="submit" class="btn btn-primary">新規登録</button>
                        @endisset
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>CSV による一括登録</h4>
                </div>
                <div class="card-body">
                    <p>
                        一括登録をするためには、まず &nbsp; <a class="btn btn-primary btn-sm" href="{{ route('rooms.download') }}">CSVのダウンロード</a> &nbsp; を行い、それに追加・修正をしたものをアップロードしてください。
                    </p>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('rooms.upload') }}">
                        @csrf
                        <x-form-element type="file" name="upfile" label="CSVファイル"/>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">一括登録</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush
