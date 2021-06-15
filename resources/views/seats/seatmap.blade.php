@php
$seats = $room->mappedSeats();
@endphp

<div class="card">
    <div class="card-header">
        <h4>座席一覧</h4>
    </div>
    <div class="card-body">
        <h6>教室全体</h6>
        <div class="table-responsive container">
            <table class="table table-bordered table-hover" id="default_seat_table">
                <thead>
                    <tr>
                        <th class="text-center">座席コード</th>
                        <th class="text-center">URL</th>
                        <th class="text-center">QR コード</th>
                        <th class="text-center">有効座席数</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">{{ $room->default_seat->code ?? '' }}</td>
                        <td class="text-center"><a href="{{ $room->default_seat->seat_url ?? '' }}">{{ $room->default_seat->seat_url ?? '' }}</a></td>
                        <td class="text-center"><img src="data:image/png;base64, {{ $room->default_seat->qrcode_base64 ?? '' }}"/></td>
                        <td class="text-center">{{ isset(array_count_values($seats)[true]) ? array_count_values($seats)[true] - 1 : 0 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h6>個別座席マップ</h6>
        <div class="table-responsive container">
            <table class="table table-bordered table-hover" id="seats_table">
                <thead>
                    <tr>
                        <td class="text-center bg-success text-white" colspan="{{ $room->cols + 1 }}">
                            <span class="">（教卓側あるいは部屋前方）</span> &nbsp; &nbsp;
                            <span id="pattern-preset-1" class="text-right btn btn-sm btn-warning">パターン１</span> &nbsp;
                            <span id="pattern-preset-2" class="text-right btn btn-sm btn-warning">パターン２</span> &nbsp;
                            <span id="pattern-preset-3" class="text-right btn btn-sm btn-warning">パターン3</span> 
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white text-center" nowrap>
                                <input type="checkbox" class="custom-control-input" id="seat_all">
                                <label class="custom-control-label" for="seat_all">All</label>
                        </th>
                    @for($col = 1 ; $col <= $room->cols ; $col++)
                        <th class="bg-primary text-white text-center" nowrap>
                            <input type="checkbox" class="custom-control-input" id="seat-cols-{{ $col }}">
                            <label class="custom-control-label" for="seat-cols-{{ $col }}">{{ $col }}</label>
                        </th>
                    @endfor
                    </tr>
                </thead>
                <tbody>
                    <form method="POST" action="{{ route('rooms.seatassign', $room->id) }}">
                    @csrf
                    <input type="hidden" name="seats[]" value="{{ '0-0' }}">
                    @for($row = 1 ; $row <= $room->rows ; $row++)
                        <tr>
                            <th class="bg-primary text-white text-center">
                                <input type="checkbox" class="custom-control-input" id="seat-rows-{{ $row }}">
                                <label class="custom-control-label" for="seat-rows-{{ $row }}">{{ $row }}</label>
                            </th>
                            @for($col = 1 ; $col <= $room->cols ; $col++)
                            <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input seat row{{ $row }} col{{ $col }}" 
                                        id="seat-{{ $row . '-' . $col }}" name="seats[]" value="{{ $row . '-' . $col }}"
                                        {{ $seats[$row . '-' . $col] ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="seat-{{ $row . '-' . $col }}"></label>
                                </div>
                            </td>
                            @endfor
                        </tr>
                    @endfor
                        <tr>
                            <td class="text-left" colspan="{{ $room->cols + 1 }}">
                                <button type="submit" class="btn btn-sm btn-primary">座席情報の更新</button>
                                <a href="{{ route('rooms.download_seats', $room->id) }}" class="btn btn-sm btn-success">座席ファイルのダウンロード</a>
                            </td>
                        </tr>
                    </form>
                    @push('scripts')
                    <script>
                        $('#seat_all').click(function() {
                            $('.seat').prop('checked', $(this).prop('checked'));
                        });
                        for (let row = 1; row <= {{ $room->rows }} ; row++) {
                            $('#seat-rows-' + row).click(function() {
                                $('.row' + row).prop('checked', $(this).prop('checked'));
                            });
                        }
                        for (let col = 1; col <= {{ $room->cols }} ; col++) {
                            $('#seat-cols-' + col).click(function() {
                                $('.col' + col).prop('checked', $(this).prop('checked'));
                            });
                        }
                        $('#pattern-preset-1').click(function () {
                            for (let row = 1; row <= {{ $room->rows }} ; row++) {
                                for (let col = 1; col <= {{ $room->cols }} ; col++) {
                                    if ((row % 2) == (col % 2)) {
                                        $('#seat-' + row + '-' + col).prop('checked', true);
                                    } else {
                                        $('#seat-' + row + '-' + col).prop('checked', false);
                                    }
                                }
                            }
                        });
                        $('#pattern-preset-2').click(function () {
                            for (let row = 1; row <= {{ $room->rows }} ; row++) {
                                for (let col = 1; col <= {{ $room->cols }} ; col++) {
                                    if ((row % 2) != (col % 2)) {
                                        $('#seat-' + row + '-' + col).prop('checked', true);
                                    } else {
                                        $('#seat-' + row + '-' + col).prop('checked', false);
                                    }
                                }
                            }
                        });
                        $('#pattern-preset-3').click(function () {
                            $('.seat').prop('checked', true);
                            for (let col = 2; col <= {{ $room->cols }} ; col = col + 3) {
                                $('.col' + col).prop('checked', false);
                            }
                        });
                    </script>
                    @endpush
                </tbody>
            </table>
        </div>
    </div>
</div>
