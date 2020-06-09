<?php

namespace App\Http\Controllers;

use App\Model\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class PermintaanController extends Controller
{
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
        DB::table('permintaans')->insert([
            'mlijo_id' => "1",
            'total' => 1000,
            'status' => "menunggu",
            'created_at' => now(),
       ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Permintaan  $permintaan
     * @return \Illuminate\Http\Response
     */
    public function show(Permintaan $permintaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Permintaan  $permintaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Permintaan $permintaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Permintaan  $permintaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permintaan $permintaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Permintaan  $permintaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permintaan $permintaan)
    {
        //
    }
}
