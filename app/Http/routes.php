<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::auth();

Route::get('/', function () {
   if(Auth::check()) {
        return redirect('/home');
    } else {
        return view('auth.login');
    }
    
});


Route::get('/home', ['middleware' => 'auth','uses' => 'HomeController@index']);

Route::get('/registersub',['middleware' => 'auth','uses' => 'RegisterSubController@index']);

Route::post('/registersub',['middleware' => 'auth','uses' => 'RegisterSubController@registersub']);

Route::get('/approvenew',['middleware' => 'auth','uses' => 'approvenew@index']);

Route::get('/approvenew/{action}/{pranno}',['middleware' => 'auth','uses' => 'approvenew@approve']);

Route::get('/subfilegen',['middleware' => 'auth','uses' => 'subfilegen@index']);

Route::post('/subfilegen/newgen',['middleware' => 'auth','uses' => 'subfilegen@newgenerate']);

Route::post('/subfilegen/regen',['middleware' => 'auth','uses' => 'subfilegen@regenerate']);

Route::post('/subfilegen/removerej',['middleware' => 'auth','uses' => 'subfilegen@removerejected']);

Route::post('/subfilegen/uploadresponse',['middleware' => 'auth','uses' => 'subfilegen@uploadresponse']);

Route::get('/dedpremium',['middleware' => 'auth','uses' => 'dedpremium@index']);

Route::get('/dedpremium/start',['middleware' => 'auth','uses' => 'dedpremium@calculatepremium']);

Route::get('/dedpremium/getjobid',['middleware' => 'auth','uses' => 'dedpremium@getjobid']);

Route::get('/dedpremium/status/{jobid}',['middleware' => 'auth','uses' => 'dedpremium@status']);

Route::get('/gencbsfile',['middleware' => 'auth','uses' => 'gencbsfile@index']);

Route::post('/gencbsfile/newgen',['middleware' => 'auth','uses' => 'gencbsfile@newgenerate']);

Route::post('/gencbsfile/regen',['middleware' => 'auth','uses' => 'gencbsfile@regenerate']);

Route::post('/gencbsfile/uploadresponse',['middleware' => 'auth','uses' => 'gencbsfile@uploadresponse']);

Route::get('/gencontrfile',['middleware' => 'auth','uses' => 'gencontrfile@index']);

Route::post('/gencontrfile/newgen',['middleware' => 'auth','uses' => 'gencontrfile@newgenerate']);

Route::post('/gencontrfile/regen',['middleware' => 'auth','uses' => 'gencontrfile@regenerate']);

Route::get('/getcbsdetails/{op}/{param1?}/{param2?}/{param3?}',['middleware' => 'auth','uses' => 'utils\getcbsdetails@index']);

Route::get('/getpremium/{param1}/{param2}/{param3}',['middleware' => 'auth','uses' => 'utils\getpremium@index'])
                                                     ->where(['param1'=>'[1][8-9]|[2][0-9]|[3][0-9]|[4][0]',
                                                                                     'param2'=>'[12345][0]{3}',
                                                                                     'param3'=>'[MQH]']);
Route::get('/getmodpremium/penupdw/{newpenamt}/{pran}',['middleware'=>'auth','uses'=>'utils\getpremium@penupdw'])
                                                ->where(['newpenamt'=>'[1-5][0]{3}','pran'=>'[0-9]+']);
Route::get('/getmodpremium/dobmod/{newdob}',['middleware'=>'auth','uses'=>'utils\getpremium@dobmod'])
                                                ->where(['newdob'=>'[1][0-9]{3}[\-][0-1][0-9][\-][0-3][0-9]']);
Route::get('/getmodpremium/freqmod/{newfreq}/{pran}',['middleware'=>'auth','uses'=>'utils\getpremium@freqmod'])
                                                ->where(['newfreq'=>'[MQH]','pran'=>'[0-9]+']);

Route::get('/volexit',['middleware'=>'auth','uses'=>'volexit@index']);

Route::get('/volexit/{pranno}',['middleware'=>'auth','uses'=>'volexit@getclosedetails'])->where(['pranno'=>'[0-9]+']);

Route::post('/volexit/{pranno}',['middleware'=>'auth','uses'=>'volexit@close'])->where(['pranno'=>'[0-9]+']);

Route::get('/genvolexitfile',['middleware' => 'auth','uses' => 'genvolexitfile@index']);

Route::post('/genvolexitfile/newgen',['middleware' => 'auth','uses' => 'genvolexitfile@newgenerate']);

Route::post('/genvolexitfile/regen',['middleware' => 'auth','uses' => 'genvolexitfile@regenerate']);

Route::get('/genmodfile/{action}',['middleware'=>'auth','uses'=>'genmodfile@index']);

Route::post('/genmodfile/{action}/{subaction}',['middleware'=>'auth','uses'=>'genmodfile@action']);

Route::get('/findatamod/{action}',['middleware'=>'auth','uses'=>'findatamodhandler@index'])->where(['action'=>'[a-z]+']);

Route::post('/findatamod/penupdw',['middleware'=>'auth','uses'=>'findatamodhandler@penupdw']);

//Route::post('/findatamod/dobmod',['middleware'=>'auth','uses'=>'findatamodhandler@dobmod']);

Route::post('/findatamod/freqmod',['middleware'=>'auth','uses'=>'findatamodhandler@freqmod']);
                           
Route::get('/changepass',['middleware'=>'auth','uses'=> 'changepassword@index']);

Route::post('/changepass',['middleware'=>'auth','uses'=> 'changepassword@changepass']);

