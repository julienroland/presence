<?php
Route::get('/', function()
{
	if(!Session::has('user'))
	{
		Auth::logout();
		return View::make('index')
		->with('expiration','Votre session à expirée, reconnectez-vous.');
	}else{

		return Redirect::to('index');
	}
});

Route::group(array('before'=>'guest'),function(){

	
	
	Route::any('identifier',array('as'=>'identifier','uses'=>'IdentifierController@login'));
	Route::get('inscription',array('as'=>'inscription','uses'=>'InscriptionController@index'));
	Route::post('inscription/creer',array('as'=>'ajouterProf','uses'=>'InscriptionController@creer'));

});

Route::group(array('before'=>'auth','before'=>'connected'),function(){

	Route::get('index',array('as'=>'accueilLog','uses'=>'HomeController@index'));

	Route::any('deconnecter',array('as'=>'deconnecter','uses'=>'DeconnecterController@index'));
	/* GERER MES COURS */ 
	Route::get('cours', array('as'=>'listerCours','uses'=>'GererCoursController@index'));
	Route::any('cours/creer', array('as'=>'creerCours','uses'=>'GererCoursController@creer'));
	Route::any('cours/{slug}', array('as'=>'voirCours','uses'=>'GererCoursController@voir'));
	Route::any('cours/{slug}/editer', array('as'=>'editerCours','uses'=>'GererCoursController@editer'));
	Route::any('cours/modifier/{slug}', array('as'=>'modifierCours','uses'=>'GererCoursController@modifier'));
	Route::any('cours/supprimer/{slug}', array('as'=>'supprimerCours','uses'=>'GererCoursController@supprimer'));
	Route::resource('cours','GererCoursController');

	
	/* GERER MES SCEANCES */

	Route::get('sceances', array('as'=>'listerSceances','uses'=>'GererSceancesController@index'));
	Route::any('sceances/creer', array('as'=>'creerSceances','uses'=>'GererSceancesController@creer'));
	Route::any('sceances/{id}', array('as'=>'voirSceances','uses'=>'GererSceancesController@voir'));
	Route::any('sceances/{id}/editer', array('as'=>'editerSceances','uses'=>'GererSceancesController@editer'));
	Route::any('sceances/modifier/{id}', array('as'=>'modifierSceances','uses'=>'GererSceancesController@modifier'));
	Route::any('sceances/supprimer/{id}', array('as'=>'supprimerSceances','uses'=>'GererSceancesController@supprimer'));
	Route::resource('sceances','GererSceancesController');

	Route::post('sceancesAjax/creer/{data}', array('as'=>'creerSceancesAjax','uses'=>'GererSceancesController@creerAjax'));
	Route::post('sceancesAjax/modifier/{data}', array('as'=>'modifierSceancesAjax','uses'=>'GererSceancesController@modifierAjax'));
	Route::get('sceancesAjax/get/{id}', array('as'=>'getSceanceAjax','uses'=>'GererSceancesController@getSceanceAjax'));
	/* GERER MES ELEVES */

	Route::get('eleves', array('as'=>'listerEleves','uses'=>'GererElevesController@index'));
	Route::any('eleves/creer', array('as'=>'creerEleves','uses'=>'GererElevesController@creer'));
	Route::any('eleves/{id}', array('as'=>'voirEleves','uses'=>'GererElevesController@voir'));
	Route::any('eleves/{id}/editer', array('as'=>'editerEleves','uses'=>'GererElevesController@editer'));
	Route::any('eleves/modifier/{id}', array('as'=>'modifierEleves','uses'=>'GererElevesController@modifier'));
	Route::any('eleves/supprimer/{id}', array('as'=>'supprimerEleves','uses'=>'GererElevesController@supprimer'));
	Route::resource('eleves','GererElevesController');

	/* GERER MES GROUPES */

	Route::get('groupes', array('as'=>'listerGroupes','uses'=>'GererGroupesController@index'));
	Route::any('groupes/creer', array('as'=>'creerGroupes','uses'=>'GererGroupesController@creer'));
	Route::any('groupes/{id}', array('as'=>'voirGroupes','uses'=>'GererGroupesController@voir'));
	Route::any('groupes/{id}/editer', array('as'=>'editerGroupes','uses'=>'GererGroupesController@editer'));
	Route::any('groupes/modifier/{id}', array('as'=>'modifierGroupes','uses'=>'GererGroupesController@modifier'));
	Route::any('groupes/supprimer/{id}', array('as'=>'supprimerGroupes','uses'=>'GererGroupesController@supprimer'));
	Route::resource('groupes','GererGroupesController');

	/* AJAX PRESENCE*/

	Route::any('gererPresence/modifier/{idPresence}/{idEleve}/{idSceance}', array('as'=>'modifierPresence','uses'=>'GererPresenceController@modifier'));
	Route::any('gererPresence/updateTotal/{idSceance}', array('as'=>'updateTotalPresence','uses'=>'GererPresenceController@updateTotalPourcentage'));
	Route::any('gererPresence/updateGroupe/{idSceance}', array('as'=>'updateGroupePresence','uses'=>'GererPresenceController@updateGroupePourcentage'));
});
