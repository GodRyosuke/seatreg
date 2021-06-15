<?php

namespace App\Http\Controllers;

use App\RegistRecord;
use Illuminate\Http\Request;

class RegistRecordController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RegistRecord  $registRecord
     * @return \Illuminate\Http\Response
     */
    public function show(RegistRecord $registRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegistRecord  $registRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(RegistRecord $registRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegistRecord  $registRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegistRecord $registRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegistRecord  $registRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegistRecord $registRecord)
    {
        //
    }
}
