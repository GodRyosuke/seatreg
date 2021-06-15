@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('建物・エリア管理') }}</h1>
    </div>
    @include('partials.statusbar')
    <div class="section-body">
        <div class="card">
            <div class="card-header">
            @isset($building)
                <h4>更新</h4>
            @else
                <h4>新規登録</h4>
            @endisset
            </div>
            <div class="card-body">
                <form method="POST" action="@isset($building) {{ route('buildings.update', $building->id) }} @else {{ route('buildings.store') }} @endisset">
                @isset($building)
                    @method('PATCH')
                @endisset
                    @csrf
                    <x-form-element name="name" label="名称" value="{{ $building->name ?? '' }}" />
                    <x-form-element type="option" name="department" value="{{ $building->department ?? '' }}"  label="部局名" items="全学共通,文学,法学,商学,経済学,工学,理学,生活科学,看護学,医学,都市経営,サテライト"/>
                    <x-form-element type="option" name="campus" value="{{ $building->campus ?? '' }}" label="キャンパス名" items="杉本,あべの,梅田"/>
                    <x-form-element name="floors" label="階数" value="{{ $building->floors ?? '' }}" />
                    <x-form-element name="location" label="位置" value="{{ $building->location ?? '' }}" />
                    <x-form-element type="long" name="memo" label="メモ" value="{{ $building->memo ?? '' }}" />
                    <div class="card-footer text-right">
                        @isset($building)
                            <button type="submit" class="btn btn-danger">削除</button> &nbsp;
                            <button type="submit" class="btn btn-primary">更新</button>
                        @else
                            <button type="submit" class="btn btn-primary">新規登録</button>
                        @endisset
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>CSV による一括登録</h4>
            </div>
            <div class="card-body">
                <p>
                    一括登録をするためには、まず &nbsp; <a class="btn btn-primary btn-sm" href="{{ route('buildings.download') }}">CSVのダウンロード</a> &nbsp; を行い、それに追加・修正をしたものをアップロードしてください。
                </p>
                <form method="POST" enctype="multipart/form-data" action="{{ route('buildings.upload') }}">
                    @csrf
                    <x-form-element type="file" name="upfile" label="CSVファイル"/>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">一括登録</button>
                    </div>
                </form>
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
