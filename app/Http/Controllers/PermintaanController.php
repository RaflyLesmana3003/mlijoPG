<?php

namespace App\Http\Controllers;

use App\Model\Permintaan;
use App\Model\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Middleware;

class PermintaanController extends Controller
{
    
    // ANCHOR withdrawal function
    public function store(Request $request)
    {
        // NOTE check if bank account exist
        $checkBankAccount = Http::withBasicAuth(config('services.midtrans_iris.CreatorApiKey'), config('services.midtrans_iris.CreatorPassword'))->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get('https://app.midtrans.com/iris/api/v1/account_validation?bank='.$request->input('bank').'&account='.$request->input('rekening'));

        $checkBank = $checkBankAccount->json();

        if (isset($checkBank['errors'])) {
            // NOTE error handling if bank doesnt exist
            return abort(500, 'Bank account doesnt exist');
        }else{
            // NOTE create payout by requesting in midtrans iris api
            $cretapayout = Http::withBasicAuth(config('services.midtrans_iris.CreatorApiKey'), config('services.midtrans_iris.CreatorPassword'))->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->post('https://app.midtrans.com/iris/api/v1/payouts', [
                "payouts"=> array([
                    "beneficiary_name"=> $request->input("atasnama"),
                    "beneficiary_account"=> $request->input("rekening"),
                    "beneficiary_bank"=> $request->input("bank"),
                    "amount"=> $request->input("jumlah"),
                    "notes"=> $request->input("note"),
                ])
            ]);
            
            // NOTE save withdraw transaction to database
            $payout = $cretapayout->json();
            if (isset($payout['payouts'][0]['reference_no'])) {
                DB::table('withdrawals')->insert(
                    [
                    "atasnama"=> $request->input("atasnama"),
                    "rekening"=> $request->input("rekening"),
                    "bank"=> $request->input("bank"),
                    "amount"=> $request->input("jumlah"),
                    "notes"=> $request->input("note"),
                    "status"=> $payout['payouts'][0]['status'],
                    "reference_no"=> $payout['payouts'][0]['reference_no'],
                    "created_at"=> now(),
                    ]
                );
            return 'permintaan withdrawal berhasil';
            }
        }
    }

    // ANCHOR receive notication from midtrans iris
    public function notificationHandler(Request $request)
    {
        // NOTE get data woth reference from database
        $withdrawal = Withdrawal::where('reference_no', '=', $request->reference_no)->firstOrFail();
        
        // NOTE set database status
        $status = $request->status;
        if ($status == "queued") {
            $withdrawal->setQueued();
        }elseif ($status == "processed") {
            $withdrawal->setprocessed();
        }elseif ($status == "completed") {
            $withdrawal->setcompleted();
        }elseif ($status == "failed") {
            $withdrawal->setfailed();
        }
    }

    // ANCHOR withdrawal function
    public function approval(Request $request)
    {
            // NOTE create payout by requesting in midtrans iris api
            $cretapayout = Http::withBasicAuth(config('services.midtrans_iris.ApproverApiKey'), config('services.midtrans_iris.ApproverPassword'))->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->post('https://app.midtrans.com/iris/api/v1/payouts/approve', [
                    "reference_no"=> $request->input("atasnama"),
                    "otp"=> $request->input("rekening"),
            ]);
    }

     // ANCHOR withdrawal function
     public function reject(Request $request)
     {
             // NOTE create payout by requesting in midtrans iris api
             $cretapayout = Http::withBasicAuth(config('services.midtrans_iris.ApproverApiKey'), config('services.midtrans_iris.ApproverPassword'))->withHeaders([
                 'Accept' => 'application/json',
                 'Content-Type' => 'application/json'
             ])->post('https://app.midtrans.com/iris/api/v1/payouts/reject', [
                     "reference_nos"=> $request->input("reference_no"),
                     "reject_reason"=> $request->input("reason"),
             ]);
            $payout = $cretapayout->json();
            dd($payout);

     }

}
