<div class="table-responsive container">
    <table class="col-sm-12 table table-striped table-md table-hover table-bordered">
        <tr class="row">
            @foreach($keys as $key)
                <th>{{ $key }}</th>
            @endforeach
        </tr>
        @foreach($records as $record)
        <tr class="row">
            @foreach($record_keys as $record_key)
                <td>{{ $record->$record_key }}</td>
            @endforeach
        </tr>
        @endforeach
    </table>
</div>
