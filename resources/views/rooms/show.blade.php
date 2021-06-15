@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('教室情報と座席管理') }}</h1>
    </div>

    <div class="section-body">
        @include('partials.statusbar')
        <div class="card">
            <div class="card-header">
                <h4>教室の詳細情報</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive container">
                    <table class="table table-bordered table-hover" id="rooms_table">
                        <thead>
                            <tr>
                                <th>名称</th>
                                <th>教室番号</th>
                                <th>建物</th>
                                <th>座席配置</th>
                                <th>収容定員（平常時）</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <form method="POST" action="{{ route('rooms.update', $room->id) }}">
                                    @method('PATCH')
                                    @csrf
                                    <td>{{ $room->name }}</td>
                                    <td>{{ $room->code }}</td>
                                    <td>{{ $room->building->name ?? '' }}</td>
                                    <td>
                                        <input type="hidden" name="change_rowcol" value="true" />
                                        縦：<input type="text" size="3" name="rows" value="{{ $room->rows ?? '' }}" />
                                        横：<input type="text" size="3" name="cols" value="{{ $room->cols ?? '' }}" />
                                    </td>
                                    <td>
                                        <input type="text" size="4" name="capacity" value="{{ $room->capacity ?? '' }}" />
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-primary">更新</button>
                                    </td>
                                </form>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- 現在の座席情報を表示 -->
        <!-- @include('seats.seatmap') -->
        @include('seats.current_seatmap');
    </div>
</section>
@endsection

