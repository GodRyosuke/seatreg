<?php

namespace App\Http\Controllers;

use App\Room;
use App\Building;
use App\RegistRecord;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use \Symfony\Component\HttpFoundation\StreamedResponse;
use \SplFileObject;
use Endroid\QrCode\QrCode;

use Gate;
use Str;

class RoomController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('部屋管理');
        $rooms = Room::all()->load('building');
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('部屋管理');
        return view('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('部屋管理');
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect(route('rooms.create'))
                        ->with('status_danger', '部屋情報を追加できませんでした。詳細を確認し再入力してください。')
                        ->withErrors($validator)
                        ->withInput();
        }
        $room = Room::create($request->all());
        if ($room) {
            $room->updateAllSeats();
        }
        return redirect(route('rooms.index'))->with('status_success', '部屋情報を追加しました');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        Gate::authorize('部屋管理');
        if ($room->default_seat == null) {
            $room->updateAllSeats();
            $room->refresh();
        }
        $default_seat = $room->default_seat;
        $RegistRecords = RegistRecord::all();
        return view('rooms.show', compact('room', 'RegistRecords'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        Gate::authorize('部屋管理');
        return view('rooms.create', compact('room'));
    }

    /**
     * 部屋にある座席を個別に有効・無効にします。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function seatAssign(Request $request, Room $room)
    {
        Gate::authorize('座席管理');
        $seats = $request['seats'];

        // いったんすべて disable に
        $room->seats()->update(['enabled' => false]);
        // チェックされたものを enable に
        $room->seats()->whereIn('location', $seats)->update(['enabled' => true]);
        return redirect(route('rooms.show', $room->id))->with('status_success', '座席登録情報を更新しました');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        Gate::authorize('部屋管理');
        if (isset($request['change_rowcol'])) {
            $room->update([
                'rows' => $request['rows'], 
                'cols' => $request['cols'],
                'capacity' => $request['capacity'],
            ]);
            $room->updateAllSeats();
            return redirect(route('rooms.show', $room->id))->with('status_success', '部屋情報を更新しました');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect(route('rooms.create'))
                        ->with('status_danger', '部屋情報を更新できませんでした。詳細を確認し再入力してください。')
                        ->withErrors($validator)
                        ->withInput();
        }
        $room->update($request->all());
        if ($room) {
            $room->updateAllSeats();
        }
        return redirect(route('rooms.index'))->with('status_success', '部屋情報を更新しました');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
        Gate::authorize('部屋管理');
    }


     /**
     * 座席情報ファイルを作成します
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function downloadSeats(Request $request, Room $room)
    {
        Gate::authorize('座席管理');
        // 2分に延長
        set_time_limit(120);
        if ($request['all']) {
            $seats = $room->seats;
        } else {
            $seats = $room->enabled_seats;
        }

        $file_prefix = 'app/';
        $zip = new \ZipArchive();
        
        $zip_file = storage_path($file_prefix . $room->code . '.zip');
        $csv_file = storage_path($file_prefix . 'seats.csv');
        $word_file = resource_path('other_stuffs/labelprint.docm');
        $zip->open($zip_file, \ZipArchive::CREATE);

        $fp = fopen($csv_file, 'w');
        $header = ['教室名', '教室コード', '行', '列', '座席番号', 'QRコードファイル', 'URL'];
        mb_convert_variables('SJIS', 'UTF-8', $header);
        fputcsv($fp, $header);
        foreach ($seats as $seat) {
            $qr_filename = $seat->full_location . '.png';
            // csv 作成
            $data = [$room->name, $room->code, $seat->row, $seat->col, $seat->full_location, $qr_filename, $seat->seat_url];
            mb_convert_variables('SJIS', 'UTF-8', $data);
            fputcsv($fp, $data);

            // QR コードファイル作成
            $qr_file = storage_path($file_prefix . $qr_filename);
            file_put_contents($qr_file, $seat->seat_qrcode);
            $zip->addFile($qr_file, $qr_filename);
        }
        fclose($fp);
        $zip->addFile($word_file, 'labelprint.docm');
        $zip->addFile($csv_file, 'seats.csv');
        $zip->close();

        return response()->download($zip_file)->deleteFileAfterSend(true);        
    }

    public function bulkStore(Request $request)
    {
        Gate::authorize('部屋管理');
        // 5分に延長
        set_time_limit(300);
        $file_path = $request->file('upfile')->path();
        $file = new \SplFileObject($file_path);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
        foreach($file as $line) {
            if ($file->key() == 0) {
                continue;
            }
            $data = [
                'id' => (int)$line[0] ?? 0,
                'name' => mb_convert_encoding($line[1], 'UTF-8', 'SJIS'),
                'code' => $line[2],
                'building_name' => mb_convert_encoding($line[3], 'UTF-8', 'SJIS'),
                'floor' => (int)$line[5] ?? 0,
                'rows' => (int)$line[6] ?? 0,
                'cols' => (int)$line[7] ?? 0,
            ];
            $room = Room::find($data['id']);
            if ($room) {
                $room->update($data);
            } else {
                $room = Room::create($data);
            }
            $building = Building::where('name', $data['building_name'])->first();
            if ($building) {
                $building->rooms()->save($room);
            }
            $room->refresh();
            $room->updateAllSeats();
        }
        return redirect(route('rooms.index'))->with('status_success', '部屋情報を一括登録しました');
    }

    public function csvDownload(Request $request)
    {
        Gate::authorize('部屋管理');
        $rooms = Room::all();
        $response = new StreamedResponse(function () use ($rooms) {
            $fp = fopen('php://output', 'w');
            $header = ['id', '教室名称', '教室コード', '建物', '部局名', '階', '行数', '列数'];
            stream_filter_prepend($fp,'convert.iconv.utf-8/cp932');

            fputcsv($fp, $header);
            foreach ($rooms as $room) {
                $data = [$room->id, $room->name, $room->code,  $room->building->name ?? '', $room->building->department ?? '', $room->floor, $room->rows, $room->cols];
                fputcsv($fp, $data);
            }
            fclose($fp);
        },
        Response::HTTP_OK,
        [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="rooms.csv"',
        ]);
        return $response;        
    }
}


