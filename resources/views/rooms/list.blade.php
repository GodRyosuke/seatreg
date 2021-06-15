<div class="card">
    <div class="card-header">
        <h4>教室一覧</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive container">
            <table class="table table-bordered table-hover" id="rooms_table">
                <thead>
                    <tr>
                        <th>名称</th>
                        <th>部屋コード</th>
                        <th>建物</th>
                        <th>行数</th>
                        <th>列数</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($rooms as $room)
                    <tr>
                        <td>{{ $room->name }}</td>
                        <td>{{ $room->code }}</td>
                        <td>{{ $room->building->name ?? '' }}</td>
                        <td>{{ $room->rows }}</td>
                        <td>{{ $room->cols }}</td>
                        <td>
                            <a href="{{ route('rooms.show', $room->id) }}" target="_blank" class="btn btn-sm btn-secondary">詳細</a> &nbsp;
                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-success">編集</a> &nbsp;
                            <a href="{{ route('rooms.destroy', $room->id) }}" class="btn btn-sm btn-danger">削除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @push('scripts')
            <script type="text/javascript">
                $(function() {
                    $('#rooms_table').DataTable();
                });
            </script>
            @endpush
        </div>
    </div>
</div>
