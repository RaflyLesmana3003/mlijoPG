<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    $transaction = DB::table('transactions')->orderBy('created_at','DESC')->get();
    // dd($transaction);
    return view('pages/customer/index',['transaction' => $transaction]);
})->name('welcome');


// NOTE midtrans transaction
Route::post('/finish', function(){
    return redirect()->route('welcome');
})->name('transaction.finish');
 
Route::post('/transaction/store', 'TransactionController@submitDonation')->name('transaction.store');
Route::post('/notification/handler', 'TransactionController@notificationHandler')->name('notification.handler');


// NOTE midtrans iris
Route::get('/tenant', function(){
    $transaction = DB::table('withdrawals')->orderBy('created_at','DESC')->get();
    return view('pages/tenant/index',['transaction' => $transaction]);
});
Route::post('/withdrawal', 'PermintaanController@store')->name('withdrawal');
Route::post('/iris/notification/handler', 'PermintaanController@notificationHandler')->name('iris.handler');