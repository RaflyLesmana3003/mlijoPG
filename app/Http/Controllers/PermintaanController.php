<?php

namespace App\Http\Controllers;

use App\Model\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Middleware;

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
    public function show(Request $request)
    {
        // dd($request->input('bank'));
        //
        $checkbankaccount = Http::withBasicAuth(config('services.midtrans_iris.CreatorApiKey'), config('services.midtrans_iris.CreatorPassword'))->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get('https://app.midtrans.com/iris/api/v1/account_validation?bank='.$request->input('bank').'&account='.$request->input('rekening'));

        $data = $checkbankaccount->json();

        if (isset($data['errors'])) {
            # code...
            echo "error";
        }else{  
               
            dd($data);
            $cretapayout = Http::withBasicAuth(config('services.midtrans_iris.CreatorApiKey'), config('services.midtrans_iris.CreatorPassword'))->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->post('https://app.midtrans.com/iris/api/v1/payouts', [
                "payouts"=> array([
                    "beneficiary_name"=> "Jon Snow",
                    "beneficiary_account"=> "1172993826",
                    "beneficiary_bank"=> "bni",
                    "beneficiary_email"=> "beneficiary@example.com",
                    "amount"=> "100000.00",
                    "notes"=> "Payout April 17"
                ])
                   

                ]);
            $payout = $cretapayout->json();
            dd($payout);
    
        }
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
