<div class="card">
    <div class="card-header">
        <h4>建物・エリア一覧</h4>
    </div>
    <div class="card-body">
        <div class="container">
            <table class="table table-border table-hover dt-responsive nowrap" width="100%" id="buildings_table">
                <thead>
                    <tr>
                        <th>名称</th>
                        <th>部局</th>
                        <th>キャンパス</th>
                        <th>階数</th>
                        <th>位置情報</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($buildings as $building)
                    <tr>
                        <td>{{ $building->name }}</td>
                        <td>{{ $building->department }}</td>
                        <td>{{ $building->campus }}</td>
                        <td>{{ $building->floors }}</td>
                        <td>{{ $building->location }}</td>
                        <td>
                            <a href="{{ route('buildings.show', $building->id) }}" class="btn btn-sm btn-secondary">詳細</a> &nbsp;
                            <a href="{{ route('buildings.edit', $building->id) }}" class="btn btn-sm btn-success">編集</a> &nbsp;
                            <a href="{{ route('buildings.destroy', $building->id) }}" class="btn btn-sm btn-danger">削除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @push('scripts')
            <script type="text/javascript">
                $(function() {
                    $('#buildings_table').DataTable();
                });
            </script>
            @endpush
        </div>
    </div>
</div>
