<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::any('login', array('before'=>'guess'));
//Route::group(array('before'=>'auth'),function(){

Route::any('identifier',array('as'=>'identifier','uses'=>'IdentifierController@login'));

//});
Route::any('deconnecter',array('as'=>'deconnecter','uses'=>'DeconnecterController@deconnecter'));
Route::group(array('before'=>'auth'),function(){

	Route::resource('gererMesCours','GererCoursController');
	Route::resource('gererMesSceances','GererSceancesController');
	Route::resource('gererMesEleves','GererElevesController');
	Route::resource('gererDesGroupes','GererGroupesController');

});