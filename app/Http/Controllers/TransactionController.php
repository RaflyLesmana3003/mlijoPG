<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Transaction;
use Veritrans_Config;
use Veritrans_Snap;
use Veritrans_Notification;

class TransactionController extends Controller
{
    /**
     * Make request global.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
 
    /**
     * Class constructor.
     *
     * @param \Illuminate\Http\Request $request User Request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
 
        // Set midtrans configuration
        Veritrans_Config::$serverKey = config('services.midtrans.serverKey');
        Veritrans_Config::$isProduction = config('services.midtrans.isProduction');
        Veritrans_Config::$isSanitized = config('services.midtrans.isSanitized');
        Veritrans_Config::$is3ds = config('services.midtrans.is3ds');
    }
 
    /**
     * Submit donation.
     *
     * @return array
     */
    public function submitDonation()
    { 
        
        \DB::transaction(function(){
          if ($this->request->discount) {
            $total = floatval($this->request->amount)-floatval($this->request->amount)*floatval($this->request->discount)/100;
          }else {
            $total = floatval($this->request->amount);
          }
            // Save donasi ke database
          $idd= now().$total.now().$this->request->customer_id.$this->request->tenant_id;

            $transaction = Transaction::create([
                'kode' => $idd,
                'customer_id' => $this->request->customer_id,
                'product_id' => $this->request->product_id,
                'tenant_id' => $this->request->tenant_id,
                'amount' => $total,
                'note' => $this->request->note,
            ]);
 
            // Buat transaksi ke midtrans kemudian save snap tokennya.
            $payload = [
                'transaction_details' => [
                    'order_id'      => $idd,
                    'gross_amount'  => $transaction->amount,
                ],
                'customer_details' => [
                    'first_name'    => $transaction->customer_id,
                    'email'         => "coba@gmail.com",
                    // 'phone'         => '08888888888',
                    // 'address'       => '',
                ],
                'item_details' => [
                    [
                        'id'       => $transaction->product_id,
                        'price'    => $transaction->amount,
                        'quantity' => 1,
                        'name'     => ucwords(str_replace('_', ' ', $transaction->product_id))
                    ]
                ]
            ];
            $snapToken = Veritrans_Snap::getSnapToken($payload);
            $transaction->snap_token = $snapToken;
            $transaction->save();
 
            // Beri response snap token
            $this->response['snap_token'] = $snapToken;
        });
 
        return response()->json($this->response);
    }
 
    /**
     * Midtrans notification handler.
     *
     * @param Request $request
     * 
     * @return void
     */
    public function notificationHandler(Request $request)
    {
        $notif = new Veritrans_Notification();
        \DB::transaction(function() use($notif) {
 
          $transaction = $notif->transaction_status;

          $type = $notif->payment_type;
          $orderId = $notif->order_id;
          $fraud = $notif->fraud_status;

          $transaksi = Transaction::where('kode', '=', $orderId)->firstOrFail();
          if ($transaction == 'capture') {
 
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
 
              if($fraud == 'challenge') {
                // TODO set payment status in merchant's database to 'Challenge by FDS'
                // TODO merchant should decide whether this transaction is authorized or not in MAP
                // $donation->addUpdate("Transaction order_id: " . $orderId ." is challenged by FDS");
                $transaksi->setPending();
              } else {
                // TODO set payment status in merchant's database to 'Success'
                // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully captured using " . $type);
                $transaksi->setSuccess();
              }
 
            }
 
          } elseif ($transaction == 'settlement') {
            dd("sad");
 
            // TODO set payment status in merchant's database to 'Settlement'
            // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully transfered using " . $type);
            $transaksi->setSuccess();
 
          } elseif($transaction == 'pending'){
 
            // TODO set payment status in merchant's database to 'Pending'
            // $donation->addUpdate("Waiting customer to finish transaction order_id: " . $orderId . " using " . $type);
            $transaksi->setPending();
 
          } elseif ($transaction == 'deny') {
            dd("sad");
 
            // TODO set payment status in merchant's database to 'Failed'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is Failed.");
            $transaksi->setFailed();
 
          } elseif ($transaction == 'expire') {
 
            // TODO set payment status in merchant's database to 'expire'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is expired.");
            $transaksi->setExpired();
 
          } elseif ($transaction == 'cancel') {
 
            // TODO set payment status in merchant's database to 'Failed'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled.");
            $transaksi->setFailed();
 
          }
 
        });
 
        return;
    }
}