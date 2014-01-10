<?php

	class GererElevesController extends \BaseController {

		protected $eleve;

		public function __construct(Eleve $eleve)
		{
			$this->eleve = $eleve;
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
		
		
		
		$paramEleves = (object)array(
			'groupe'=>Groupe::get()->toArray(),
			'option'=>Option::get()->toArray(),
			'annees'=>Annee::get()->toArray(),
			'anneeLevel'=>anneeLevel::get()->toArray(),
			'cours'=>Cours::get()->toArray(),

			);

		Session::put('paramEleves',$paramEleves);

		$eleves = Prof::getEleves($id);
		

		/*$sceances = $prof->cours()->distinct()->with(array('sceance','sceance.day'))->with('option')->get()->toArray();*/

		return View::make('gererMesEleves.index')->with(compact('eleves'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function creer()
	{
		
		for($i=0;$i<=count(Session::get('paramEleves')->groupe)-1;$i++)
		{
			$listGroupe[Session::get('paramEleves')->groupe[$i]['id']] = Session::get('paramEleves')->groupe[$i]['id'];

		}

		for($i=0;$i<=count(Session::get('paramEleves')->annees)-1;$i++)
		{
			$listAnnee[Session::get('paramEleves')->annees[$i]['id']] = Session::get('paramEleves')->annees[$i]['id'];
		}

		for($i=0;$i<=count(Session::get('paramEleves')->anneeLevel)-1;$i++)
		{
			$listAnneeLevel[Session::get('paramEleves')->anneeLevel[$i]['id']] = Session::get('paramEleves')->anneeLevel[$i]['nom'];
		}

		for($i=0;$i<=count(Session::get('paramEleves')->option)-1;$i++)
		{
			$listOption[Session::get('paramEleves')->option[$i]['id']] = Session::get('paramEleves')->option[$i]['nom'];
		}

		for($i=0;$i<=count(Session::get('paramEleves')->cours)-1;$i++)
		{
			$listCours[Session::get('paramEleves')->cours[$i]['id']] = Session::get('paramEleves')->cours[$i]['nom'];
		}

		return View::make('gererMesEleves.creer')
		->with(compact('listGroupe'))
		->with(compact('listAnnee'))
		->with(compact('listAnneeLevel'))
		->with(compact('listOption'))
		->with(compact('listCours'));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store()
	{
		$newNom = Input::get('nom');
		$nomWellFormated =  str_replace(" ", "", $newNom);
		$newSlug = Input::get('prenom') . '-' .$nomWellFormated;

		$input = array(
			'nom'=>Input::get('nom'),
			'prenom'=>Input::get('prenom'),
			'email'=>Input::get('email'),
			'slug'=>$newSlug,
			'groupe'=>Input::get('groupe'),
			'annee'=>Input::get('annee'),
			'niveau d\'annee'=>Input::get('anneeLevel'),
			'option'=>Input::get('option'),
			'photo'=>'',
			);
		$rules = array(
			'prenom'=>'required|alpha_dash',
			'nom'=>'required|regex:/^([a-z\x20])+$/i',
			'groupe'=>'required|numeric',
			'email'=>'required|email|unique:eleves',
			'photo'=>'',
			'slug'=>'required|unique:eleves',
			'annee'=>'required|numeric',
			'niveau d\'annee'=>'required|numeric',
			'option'=>'required|numeric',
			);
		
		
		$validation = Validator::make($input, $rules);

		if ($validation->passes())
		{
			
			$eleve = new Eleve(array(
				'nom'=>ucwords(Input::get('nom')),
				'prenom'=>ucwords(Input::get('prenom')),
				'email'=>Input::get('email'),
				'slug'=>$newSlug,
				'photo'=>'',
				'groupe_id'=>Input::get('groupe'),
				'annees_encours_id'=>Input::get('annee'),
				'anneeLevel_id'=>Input::get('anneeLevel'),
				'options_id'=>Input::get('option'),

				));

			$eleve->save();

			if(!empty(Input::get('cours')))
			{
				$coursHasIds = Input::get('cours');

				$eleves_id = $eleve->id;

				$eleveFind = Eleve::find($eleves_id);

				foreach($coursHasIds as $cours_id){

					$eleveFind->cours()->attach($cours_id);
					
				}

			}

			

			return Redirect::route('listerEleves')
			->with('success', Input::get('prenom').' '.Input::get('nom').' à été correctement crée');
		}

		return Redirect::route('creerEleves')
		->withInput()
		->withErrors($validation)
		->with('message', 'There were validation errors.');

	}

/**
* Display the specified resource.
*
* @param  int  $id
* @return Response
*/
public function voir($slug)
{

	$eleve = Eleve::whereSlug($slug)->with('groupe','groupe.option','anneeLevel')->first();
	
	return View::make('gererMesEleves.voir', compact('eleves'))
	->with(compact('eleve'));
}

/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return Response
*/
public function editer($slug)
{
	$eleve = Eleve::whereSlug($slug)->first();
	
	if (is_null($eleve))
	{
		return Redirect::route('gererMesEleves.index');
	}
	
	
	for($i=0;$i<=count(Session::get('paramEleves')->groupe)-1;$i++)
	{
		$listGroupe[Session::get('paramEleves')->groupe[$i]['id']] = Session::get('paramEleves')->groupe[$i]['id'];
		
	}

	for($i=0;$i<=count(Session::get('paramEleves')->annees)-1;$i++)
	{
		$listAnnee[Session::get('paramEleves')->annees[$i]['id']] = Session::get('paramEleves')->annees[$i]['id'];
	}

	for($i=0;$i<=count(Session::get('paramEleves')->anneeLevel)-1;$i++)
	{
		$listAnneeLevel[Session::get('paramEleves')->anneeLevel[$i]['id']] = Session::get('paramEleves')->anneeLevel[$i]['nom'];
	}

	for($i=0;$i<=count(Session::get('paramEleves')->option)-1;$i++)
	{
		$listOption[Session::get('paramEleves')->option[$i]['id']] = Session::get('paramEleves')->option[$i]['nom'];
	}


	for($i=0;$i<=count(Session::get('paramEleves')->cours)-1;$i++)
	{
		$listCours[Session::get('paramEleves')->cours[$i]['id']] = Session::get('paramEleves')->cours[$i]['nom'];
	}

	return View::make('gererMesEleves.editer')
	->with(compact('eleve'))
	->with(compact('listGroupe'))
	->with(compact('listAnnee'))
	->with(compact('listAnneeLevel'))
	->with(compact('listOption'))
	->with(compact('listCours'));
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
	$nomWellFormated =  str_replace(" ", "", $newNom);
	$newSlug = Input::get('prenom') . '-' .$nomWellFormated;

	$input = array(
		'nom'=>Input::get('nom'),
		'prenom'=>Input::get('prenom'),
		'email'=>Input::get('email'),
		'slug'=>$newSlug,
		'groupe'=>Input::get('groupe'),
		'annee'=>Input::get('annee'),
		'niveau d\'annee'=>Input::get('anneeLevel'),
		'option'=>Input::get('option'),
		);
	$rules = array(
		'prenom'=>'required|alpha_dash',
		'nom'=>'required|regex:/^([a-z\x20])+$/i',
		'groupe'=>'required|numeric',
		'photo'=>'',
		'slug'=>'alpha_dash',
		'annee'=>'required|numeric',
		'niveau d\'annee'=>'required|numeric',
		'option'=>'required|numeric',
		);

	$validation = Validator::make($input, $rules);

	if ($validation->passes())
	{
		
		$eleve = Eleve::whereSlug($slug);

		$eleve->update(array(
			'nom'=>Input::get('nom'),
			'prenom'=>Input::get('prenom'),
			'email'=>Input::get('email'),
			'slug'=>$newSlug,
			'groupe_id'=>Input::get('groupe'),
			'annees_encours_id'=>Input::get('annee'),
			'anneeLevel_id'=>Input::get('anneeLevel'),
			'options_id'=>Input::get('option'),
			));

		$eleves = $eleve->first();

		if(!empty(Input::get('cours')))
		{

			$coursHasIds = Input::get('cours');
			
			$eleves_id = $eleves->id;

			$eleveFind = Eleve::find($eleves_id);

			foreach($coursHasIds as $cours_id){

				$eleveFind->cours()->attach($cours_id);

			}

		}

		
		return Redirect::route('listerEleves')
		->with('success','L\'élève '.$eleves->prenom.' '.$eleves->nom.' correctement modifié');
	}

	return Redirect::route('editerEleves',$slug)
	->withInput()
	->withErrors($validation)
	->with('message', 'There were validation errors.');
	return View::make('gererMesEleves.editer');
}

/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return Response
*/
public function supprimer($slug)
{
	
	$idEleve = Eleve::whereSlug($slug)->first(['id']);

	$id = $idEleve->id;

	$eleveRelation = Eleve::find($id)->cours()->detach();
	
	$eleve = Eleve::whereSlug($slug)->delete();
	
	
	if($eleve)
	{
		return Redirect::route('listerEleves')
		->with('success','L\'elève '.$slug.' bien supprimée !');
	}
	else
	{
		return Redirect::route('listerEleves')
		->with('error', 'La suppression à échouée, vérifier que l\'élève existe toujours bien (F5).');
	}
}

}