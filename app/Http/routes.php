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
Route::get('/',function(){
    return view('index');
});
Route::get('/login',[
    'uses'=>'AdminController@getLogin',
    'as'=>'admin.login'
]);


Route::post('/login',[
    'uses'=>'AdminController@postLogin',
    'as'=>'admin.login'
]);
Route::get('/odjava',function(){
    Auth::logout();
    return view('index');
});
Route::get('/zubar',[
    'uses'=>'AdminController@getZubar',
    'as'=>'zubar.index'
]);
Route::get('/pacijent',[
    'uses'=>'AdminController@getPacijent',
    'as'=>'pacijent.index'
]);
Route::post('/registracija', 'RegistrationController@store');
Route::get('/registracija', 'RegistrationController@getIndex');

Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'RegistrationController@confirm'
]);
//Pass reset routes
Route::get('password/reset/{token?}','Auth\PasswordController@showResetForm');
Route::post('password/email','Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset','Auth\PasswordController@reset');


//Route::controller('/{slug}','PrezenterSajtaC');
//Route::controller('/administracija','AdministracijaSajtaC');
//Route::controller('/super-administracija','SuperAdministracijaC');
//Route::controller('/','OsnovniPrezenterC');

