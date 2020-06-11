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

Route::get('/tenant', function(){
    return view('pages/tenant/index');
});
Route::post('/withdrawal', 'PermintaanController@show')->name('withdrawal');

Route::get('/admin', function(){
    return view('pages/admin/index');
});

Route::post('/finish', function(){
    return redirect()->route('welcome');
})->name('transaction.finish');
 
Route::post('/transaction/store', 'TransactionController@submitDonation')->name('transaction.store');
Route::post('/notification/handler', 'TransactionController@notificationHandler')->name('notification.handler');

Route::get('/qqq', 'PermintaanController@show');
 