<?php

namespace App\Http\Controllers;

use App\Building;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use \Symfony\Component\HttpFoundation\StreamedResponse;
use \SplFileObject;
use Gate;

class BuildingController extends Controller
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
        Gate::authorize('建物管理');

        $buildings = Building::all();
        return view('buildings.index', compact('buildings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('建物管理');

        return view('buildings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('建物管理');
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'department' => 'required|max:255',
            'campus' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect(route('buildings.create'))
                        ->with('status_danger', '建物情報を追加できませんでした。詳細を確認し再入力してください。')
                        ->withErrors($validator)
                        ->withInput();
        }
        $building = Building::create($request->all());
        return redirect(route('buildings.index'))->with('status_success', '建物情報を追加しました');
    }

    public function bulkStore(Request $request)
    {
        Gate::authorize('建物管理');
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
                'name' => mb_convert_encoding($line[0], 'UTF-8', 'SJIS'),
                'floors' => mb_convert_encoding($line[1], 'UTF-8', 'SJIS'),
                'department' => mb_convert_encoding($line[2], 'UTF-8', 'SJIS'),
                'campus' => mb_convert_encoding($line[3], 'UTF-8', 'SJIS'),
            ];
            $building = Building::where('name', $data['name'])->first();
            if ($building) {
                $building->update($data);
            } else {
                $building = Building::create($data);
            }
        }
        return redirect(route('buildings.index'))->with('status_success', '建物情報を一括登録しました');
    }

    public function csvDownload(Request $request)
    {
        Gate::authorize('建物管理');

        $buildings = Building::all();
        $response = new StreamedResponse(function () use ($buildings) {
            $fp = fopen('php://output', 'w');
            $header = ['名称', '階数', '部局', 'キャンパス'];
            stream_filter_prepend($fp,'convert.iconv.utf-8/cp932');

            fputcsv($fp, $header);
            foreach ($buildings as $building) {
                $data = [$building->name, $building->floors, $building->department, $building->campus];
                fputcsv($fp, $data);
            }
            fclose($fp);
        },
        Response::HTTP_OK,
        [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="buildings.csv"',
        ]);
        return $response;        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function show(Building $building)
    {
        Gate::authorize('建物管理');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function edit(Building $building)
    {
        Gate::authorize('建物管理');
        //
        return view('buildings.create', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Building $building)
    {
        Gate::authorize('建物管理');

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'department' => 'required|max:255',
            'campus' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect(route('buildings.edit', $building->id))
                        ->with('status_danger', '建物情報を更新できませんでした。詳細を確認し再入力してください。')
                        ->withErrors($validator)
                        ->withInput();
        }
        $building->update($request->all());
        return redirect(route('buildings.index'))->with('status_success', '建物情報を更新しました');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function destroy(Building $building)
    {
        Gate::authorize('建物管理');
        //
    }
}
