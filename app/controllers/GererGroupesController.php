	<?php

	class GererGroupesController extends \BaseController {

		protected $groupe;

		public function __construct(Groupe $groupe)
		{
			$this->groupe = $groupe;
		}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$id = Session::get('user')['id'];
		$prof= Prof::find($id);
		
		$paramGroupe = (object)array(
			'cours'=>Cours::get()->toArray(),
			'anneeLevel'=>AnneeLevel::get()->toArray(),
			'options'=>Option::get()->toArray(),
			'eleves'=>Eleve::get()->toArray(),

			);

		Session::put('paramGroupe',$paramGroupe);

		$groupes = $prof->groupe()->with('option','anneeLevel')->get();
		
		/*$groupe=Prof::getGroupeAndCours($id);*/
		

		return View::make('gererMesGroupes.index')->with(compact('groupes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function creer()
	{


		for($i=0;$i<=count(Session::get('paramGroupe')->cours)-1;$i++)
		{
			$listCours[Session::get('paramGroupe')->cours[$i]['id']] = Session::get('paramGroupe')->cours[$i]['nom'];
		}

		for($i=0;$i<=count(Session::get('paramGroupe')->options)-1;$i++)
		{
			$listOption[Session::get('paramGroupe')->options[$i]['id']] = Session::get('paramGroupe')->options[$i]['nom'];
		}

		for($i=0;$i<=count(Session::get('paramGroupe')->eleves)-1;$i++)
		{
			$listEleves[Session::get('paramGroupe')->eleves[$i]['slug']] = Session::get('paramGroupe')->eleves[$i]['nom'];
		}

		for($i=0;$i<=count(Session::get('paramGroupe')->anneeLevel)-1;$i++)
		{
			$listAnneeLevel[Session::get('paramGroupe')->anneeLevel[$i]['id']] = Session::get('paramGroupe')->anneeLevel[$i]['nom'];
		}
		

		return View::make('gererMesGroupes.creer')
		->with(compact('listCours'))
		->with(compact('listEleves'))
		->with(compact('listOption'))
		->with(compact('listAnneeLevel'));
		
	}

	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store()
	{
		$nom =Input::get('nom');
		$input= Input::all();
		
		$rules = array(
			'nom'=>'required',
			'anneeLevel'=>'required',
			'option'=>'required',
			'cours'=>'required',
			);
		$validation = Validator::make($input, $rules);

		if ($validation->passes())
		{
			$groupe = new Groupe(array(
				'options_id'=>Input::get('option'),
				'profs_id'=>Session::get('user')['id'],
				'nom'=>Input::get('nom'),
				));

			$groupe->save();

			return Redirect::route('listerGroupes');
		}

		return Redirect::route('creerGroupes')
		->withInput()
		->withErrors($validation);

	}

/**
* Display the specified resource.
*
* @param  int  $id
* @return Response
*/
public function voir($slug)
{

	$groupe = Groupe::whereSlug($slug)->with('anneeLevel','option','eleve','cours')->first();
	
	return View::make('gererMesGroupes.voir', compact('groupe'));
	
	
}

/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return Response
*/
public function editer($slug)
{
	$groupes = Groupe::whereSlug($slug)->with('anneeLevel','cours')->first();
	
	
	
	if (is_null($groupes))
	{
		return Redirect::route('gererMesGroupes.index');
	}
	

	foreach($groupes->cours as $cours) //ne pas avoir les cours avec qui on est déjà lié
	{

		for($i=0;$i<=count(Session::get('paramGroupe')->cours)-1;$i++)
		{
			if(Session::get('paramGroupe')->cours[$i]['slug']!== $cours->slug)
			{
				$listCours[Session::get('paramGroupe')->cours[$i]['slug']] = Session::get('paramGroupe')->cours[$i]['slug'];
			}
		}

	}

	for($i=0;$i<=count(Session::get('paramGroupe')->options)-1;$i++)
	{
		$listOption[Session::get('paramGroupe')->options[$i]['id']] = Session::get('paramGroupe')->options[$i]['nom'];
	}

	for($i=0;$i<=count(Session::get('paramGroupe')->eleves)-1;$i++)
	{
		$listEleves[Session::get('paramGroupe')->eleves[$i]['slug']] = Session::get('paramGroupe')->eleves[$i]['nom'];
	}

	for($i=0;$i<=count(Session::get('paramGroupe')->anneeLevel)-1;$i++)
	{
		$listAnneeLevel[Session::get('paramGroupe')->anneeLevel[$i]['id']] = Session::get('paramGroupe')->anneeLevel[$i]['nom'];
	}

	if($groupes->anneeLevel->count())
	{

		for($i=0;$i<=count($groupes->anneeLevel)-1;$i++)
		{
			$listHasAnneeLevel[$groupes->anneeLevel[$i]['id']] = $groupes->anneeLevel[$i]['id'];
		}
	}
	else
	{
		$listHasAnneeLevel[] = [];
	}

	return View::make('gererMesGroupes.editer')
	->with(compact('groupes'))
	->with(compact('listCours'))
	->with(compact('listEleves'))
	->with(compact('listOption'))
	->with(compact('listAnneeLevel'))
	->with(compact('listHasAnneeLevel'));
}

/**
* Update the specified resource in storage.
*
* @param  int  $id
* @return Response
*/
public function modifier($slug)
{
	$newNom = Input::get('nom');
	
	$newSlug =  str_replace(" ", "-", $newNom);

	$input= array(
		'nom'=>Input::get('nom'),
		'anneeLevel'=>Input::get('anneeLevel'),
		'option'=>Input::get('option'),
		'cours'=>Input::get('cours'),
		'slug'=>$newSlug,
		);
	$rules= array(
		'nom'=>'required',
		'anneeLevel'=>'required',
		'option'=>'required',
		'cours'=>'numeric',
		'slug'=>'',
		);

	$validation = Validator::make($input, $rules);

	if ($validation->passes())
	{
		
		$groupe = Groupe::whereSlug($slug);
		
		$groupe->update(array(
			'nom'=>Input::get('nom'),
			'options_id'=>Input::get('option'),
			'slug'=>$newSlug,
			));

		$groupes = $groupe->first();

		if(!empty(Input::get('cours')))
		{
			
			$coursHasIds = Input::get('cours');
			
			$groupes_id = $groupes->id;

			$groupes_slug = $groupes->slug;

			$groupeFind = Groupe::find($groupes_id);

			foreach($coursHasIds as $groupes_id){

				$groupeFind->cours()->attach($groupes_id);

			}

		}

		return Redirect::route('listerGroupes')
		->with('success','Groupe '.$groupes->nom.' 	correctement modifié');

	}

	return Redirect::route('editerGroupes',$slug)
	->withInput()
	->withErrors($validation)
	->with('message', 'There were validation errors.');
	
}

/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return Response
*/
public function supprimer($slug)
{
	$idGroupe = Groupe::whereSlug($slug)->first(['id']);

	$id = $idGroupe->id;

	$eleveRelation = Groupe::find($id)->cours()->detach();
	$eleveRelation2 = Groupe::find($id)->anneeLevel()->detach();
	
	$groupe = Groupe::whereSlug($slug)->delete();

	if($groupe)
	{
		return Redirect::route('listerGroupes')
		->with('success','Groupe bien supprimée !');
	}
	else
	{
		return Redirect::route('listerGroupes')
		->with('error', 'La suppression à échouée, vérifier que le groupe existe toujours bien (F5).');
	}
}

}