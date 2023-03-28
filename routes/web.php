<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    $emails = \App\Models\Campaign::all();
    foreach ($emails as $key => $email) {
        Mail::to($email->email)->send(new \App\Mail\Campaign($email->email));
        break;
        sleep(1000);
    }
    return view('welcome');
})->name('send-mail');


Route::get('/images',function(){
    logger(request()->all());
    \DB::table('campaigns')->where('email',request()->email)->update(['open'=>1]);
    return response()->file(public_path("1x1.png"));
})->name('track_open');


Route::get('/track-mail',function(){

    \DB::table('campaigns')->where('email',request()->email)->update(['click'=>1]);
    // return redirect(request()->url);
    return redirect()->away(request()->url);

})->name('track_click');
