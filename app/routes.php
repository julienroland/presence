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

	Route::get('gererMesCours/creer', array('as'=>'creerCours','uses'=>'GererCoursController@creer'));
	Route::get('gererMesCours/{slug}/editer', array('as'=>'editerCours','uses'=>'GererCoursController@editer'));
	Route::get('gererMesCours/modifier/{slug}', array('as'=>'modifierCours','uses'=>'GererCoursController@modifier'));
	Route::get('gererMesCours/supprimer/{slug}', array('as'=>'supprimerCours','uses'=>'GererCoursController@supprimer'));
	Route::resource('gererMesCours','GererCoursController');

	Route::resource('gererMesSceances','GererSceancesController');
	Route::resource('gererMesEleves','GererElevesController');
	Route::resource('gererDesGroupes','GererGroupesController');

});

route::get('test',function(){
	$sceance = Sceance::find(1);
	foreach($sceance->eleve as $eleve){
		print '<li>' . $eleve->nom . ' ' . $eleve->pivot->presence_id;
	}
});