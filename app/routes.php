<?php
Route::get('/', function()
	{
		if(!Session::has('user'))
		{
			Auth::logout();
			return View::make('index')
			->with('expiration','Votre session à expirée, reconnectez-vous.');
		}else{

		return View::make('indexLog');
		}
	});

//Route::model('prof', 'Prof');	
Route::get('index',array('as'=>'accueilLog','uses'=>'HomeController@index'));

Route::group(array('before'=>'guest'),function(){

	
	
	Route::any('identifier',array('as'=>'identifier','uses'=>'IdentifierController@login'));
	Route::get('inscription',array('as'=>'inscription','uses'=>'InscriptionController@index'));
	Route::post('inscription/creer',array('as'=>'ajouterProf','uses'=>'InscriptionController@creer'));

});

Route::group(array('before'=>'auth','before'=>'connected'),function(){


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

	/* AJAX PRESENCE*/

	Route::any('gererPresence/modifier/{idPresence}/{idEleve}/{idSceance}', array('as'=>'modifierPresence','uses'=>'GererPresenceController@modifier'));
	Route::any('gererPresence/updateTotal/{idSceance}', array('as'=>'updateTotalPresence','uses'=>'GererPresenceController@updateTotalPourcentage'));
	Route::any('gererPresence/updateGroupe/{idSceance}', array('as'=>'updateGroupePresence','uses'=>'GererPresenceController@updateGroupePourcentage'));
});
