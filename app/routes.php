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
Route::group(array('before'=>'guess'),function(){

	
	Route::any('identifier',array('as'=>'identifier','uses'=>'IdentifierController@login'));
	Route::get('inscription',array('as'=>'inscription','uses'=>'InscriptionController@index'));
	Route::post('inscription/creer',array('as'=>'ajouterProf','uses'=>'InscriptionController@creer'));

});




Route::group(array('before'=>'auth'),function(){
	Route::any('deconnecter',array('as'=>'deconnecter','uses'=>'DeconnecterController@deconnecter'));
	/* GERER MES COURS */ 
	Route::get('gererMesCours', array('as'=>'listerCours','uses'=>'GererCoursController@index'));
	Route::any('gererMesCours/creer', array('as'=>'creerCours','uses'=>'GererCoursController@creer'));
	Route::any('gererMesCours/{slug}', array('as'=>'voirCours','uses'=>'GererCoursController@voir'));
	Route::any('gererMesCours/{slug}/editer', array('as'=>'editerCours','uses'=>'GererCoursController@editer'));
	Route::any('gererMesCours/modifier/{slug}', array('as'=>'modifierCours','uses'=>'GererCoursController@modifier'));
	Route::any('gererMesCours/supprimer/{slug}', array('as'=>'supprimerCours','uses'=>'GererCoursController@supprimer'));
	Route::resource('gererMesCours','GererCoursController');

	/* GERER MES SCEANCES */

	Route::get('gererMesSceances', array('as'=>'listerSceances','uses'=>'GererSceancesController@index'));
	Route::any('gererMesSceances/creer', array('as'=>'creerSceances','uses'=>'GererSceancesController@creer'));
	Route::any('gererMesSceances/{slug}', array('as'=>'voirSceances','uses'=>'GererSceancesController@voir'));
	Route::any('gererMesSceances/{slug}/editer', array('as'=>'editerSceances','uses'=>'GererSceancesController@editer'));
	Route::any('gererMesSceances/modifier/{slug}', array('as'=>'modifierSceances','uses'=>'GererSceancesController@modifier'));
	Route::any('gererMesSceances/supprimer/{slug}', array('as'=>'supprimerSceances','uses'=>'GererSceancesController@supprimer'));
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