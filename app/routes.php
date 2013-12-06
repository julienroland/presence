<?php

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
	Route::any('gererMesSceances/{id}', array('as'=>'voirSceances','uses'=>'GererSceancesController@voir'));
	Route::any('gererMesSceances/{id}/editer', array('as'=>'editerSceances','uses'=>'GererSceancesController@editer'));
	Route::any('gererMesSceances/modifier/{id}', array('as'=>'modifierSceances','uses'=>'GererSceancesController@modifier'));
	Route::any('gererMesSceances/supprimer/{id}', array('as'=>'supprimerSceances','uses'=>'GererSceancesController@supprimer'));
	Route::resource('gererMesSceances','GererSceancesController');

	/* GERER MES ELEVES */

	Route::get('gererMesEleves', array('as'=>'listerEleves','uses'=>'GererElevesController@index'));
	Route::any('gererMesEleves/creer', array('as'=>'creerEleves','uses'=>'GererElevesController@creer'));
	Route::any('gererMesEleves/{id}', array('as'=>'voirEleves','uses'=>'GererElevesController@voir'));
	Route::any('gererMesEleves/{id}/editer', array('as'=>'editerEleves','uses'=>'GererElevesController@editer'));
	Route::any('gererMesEleves/modifier/{id}', array('as'=>'modifierEleves','uses'=>'GererElevesController@modifier'));
	Route::any('gererMesEleves/supprimer/{id}', array('as'=>'supprimerEleves','uses'=>'GererElevesController@supprimer'));
	Route::resource('gererMesEleves','GererElevesController');

	/* GERER MES GROUPES */

	Route::get('gererMesGroupes', array('as'=>'listerGroupes','uses'=>'GererGroupesController@index'));
	Route::any('gererMesGroupes/creer', array('as'=>'creerGroupes','uses'=>'GererGroupesController@creer'));
	Route::any('gererMesGroupes/{id}', array('as'=>'voirGroupes','uses'=>'GererGroupesController@voir'));
	Route::any('gererMesGroupes/{id}/editer', array('as'=>'editerGroupes','uses'=>'GererGroupesController@editer'));
	Route::any('gererMesGroupes/modifier/{id}', array('as'=>'modifierGroupes','uses'=>'GererGroupesController@modifier'));
	Route::any('gererMesGroupes/supprimer/{id}', array('as'=>'supprimerGroupes','uses'=>'GererGroupesController@supprimer'));
	Route::resource('gererMesGroupes','GererGroupesController');

});
