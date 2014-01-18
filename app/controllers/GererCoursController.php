<?php

class GererCoursController extends \BaseController {

	protected $cours;

	public function __construct(Cours $cours)
	{
		$this->cours = $cours;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
		$user = unserialize(Session::get('user'));
		$id = $user['id'];
		$prof= Prof::find($id);

		$title="Cours";
		$head="Page de vos cours de l'application présence";
		
		$paramCours = (object)array(
			'groupe'=>Groupe::get()->toArray(),
			'option'=>Option::get()->toArray(),
			'anneeLevel'=>AnneeLevel::get()->toArray(),
			);

		Session::put('paramCours',$paramCours);

		$cours = $prof->cours()->with('option','groupe')->distinct()->get();
		
		/* PRESENCE PAR COURS */
		$percentByCours = [];
		$totalCours = Prof::countCours($id);
		$i = 0;
		foreach($cours as $cour){

			$percentByCours[$i] =['nom'=>$cour->nom,'slug'=>$cour->slug,'percent'=>round((Helpers::toPercent(Cours::getPresence($cour->id),Cours::getpresent($cour->id)) / $totalCours),2)];

			$i++;
		}
		
		/* Pourcentage total tous les cours */
		$presenceTotal = Prof::getTotalPresence($id);
		$presentTotal = Prof::getTotalPresent($id); 
		$percentTotal = Helpers::toPercent($presentTotal,$presenceTotal).'%';

		return View::make('gererMesCours.index')->with(compact('cours','title','head','percentTotal','percentByCours'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function creer()
	{
		
		for($i=0;$i<=count(Session::get('paramCours')->anneeLevel)-1;$i++)
		{
			$listAnneeLevel[Session::get('paramCours')->anneeLevel[$i]['id']] = Session::get('paramCours')->anneeLevel[$i]['nom'];
		}

		for($i=0;$i<=count(Session::get('paramCours')->option)-1;$i++)
		{
			$listOption[Session::get('paramCours')->option[$i]['id']] = Session::get('paramCours')->option[$i]['nom'];
		}

		for($i=0;$i<=count(Session::get('paramCours')->groupe)-1;$i++)
		{
			$listGroupe[Session::get('paramCours')->groupe[$i]['id']] = Session::get('paramCours')->groupe[$i]['nom'];
		}

		return View::make('gererMesCours.creer')
		->with(compact('listAnneeLevel'))
		->with(compact('listOption'))
		->with(compact('listGroupe'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$nom =Input::get('nom');
		$input= array(
			'intitulé'=>$nom,
			'duree'=>Input::get('duree'),
			'options'=>Input::get('option'),
			'groupe'=>Input::get('groupe'),
			'année étude'=>Input::get('anneeLevel'),
			);
		$validation = Validator::make($input, Cours::$rules);

		if ($validation->passes())
		{

			$cours = new Cours(array(
				'nom'    => $nom,
				'duree'=>Input::get('duree'),
				'anneeLevel_id'=>Input::get('anneeLevel'),
				));

			$cours->save();
			
			$newSlug = $this->cours->whereSlug($cours->slug)->first();

			$cours->prof()->attach(array(
				'cours_id'=>$newSlug->id,
				'profs_id'=>Session::get('user')['id']
				));

			foreach(Input::get('groupe') as $groupe_id){

				$cours->groupe()->attach($groupe_id);

			}
			foreach(Input::get('option') as $option_id){

				$cours->option()->attach($option_id);

			}
			
			return Redirect::route('listerCours');
		}

		return Redirect::route('creerCours')
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

		$cours = $this->cours->whereSlug($slug)
		->with('sceance.cours.groupe','option','groupe','eleve.groupe')
		->first();
		
		return View::make('gererMesCours.voir', compact('cours'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editer($slug)
	{
		
		$cours = $this->cours->whereSlug($slug)->with('option','groupe','anneeLevel')->first();
		
		if (is_null($cours))
		{
			return Redirect::route('gererMesCours.index');
		}

		for($i=0;$i<=count(Session::get('paramCours')->anneeLevel)-1;$i++)
		{
			$listAnneeLevel[Session::get('paramCours')->anneeLevel[$i]['id']] = Session::get('paramCours')->anneeLevel[$i]['nom'];
		}

		for($i=0;$i<=count(Session::get('paramCours')->option)-1;$i++)
		{
			$listOption[Session::get('paramCours')->option[$i]['id']] = Session::get('paramCours')->option[$i]['nom'];
		}

		for($i=0;$i<=count(Session::get('paramCours')->groupe)-1;$i++)
		{
			$listGroupe[Session::get('paramCours')->groupe[$i]['id']] = Session::get('paramCours')->groupe[$i]['nom'];
		}

		if($cours->groupe->count()){

			for($i=0;$i<=count($cours->groupe)-1;$i++)
			{

				$listHasGroupe[$cours->groupe[$i]['id']] = $cours->groupe[$i]['id'];
			}
		}
		else
		{
			$listHasGroupe[] = [];
		}

		if($cours->option->count()){

			for($i=0;$i<=count($cours->option)-1;$i++)
			{

				$listHasOption[$cours->option[$i]['id']] = $cours->option[$i]['id'];
			}
		}
		else
		{
			$listHasOption[] = [];
		}

		return View::make('gererMesCours.editer')
		->with(compact('cours'))
		->with(compact('listAnneeLevel'))
		->with(compact('listOption'))
		->with(compact('listHasGroupe'))
		->with(compact('listHasOption'))
		->with(compact('listGroupe'));
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

		$coursId = Cours::whereSlug($slug)->first(['id']);
		$coursId = $coursId->id;

		$input= array(
			'intitulé'=>Input::get('nom'),
			'duree'=>Input::get('duree'),
			'options'=>Input::get('option'),
			'groupe'=>Input::get('groupe'),
			'année étude'=>Input::get('anneeLevel'),
			);
		
		$validation = Validator::make($input, Cours::$rules);
		
		if ($validation->passes())
		{
			
			$cours = $this->cours->where('slug',$slug)->first();
			

			$cours->update(array(
				'nom'=>Input::get('nom'),
				'slug'=>$newSlug,
				'duree'=>Input::get('duree'),
				'anneeLevel_id'=>Input::get('anneeLevel'),
				));

			if(!empty(Input::get('nom')))
			{

				$coursFind = Cours::find($coursId);

				$groupeRelation = $coursFind->groupe()->detach();

				foreach(Input::get('groupe') as $groupes_id){

					$coursFind->groupe()->attach($groupes_id);


				}

				$optionRelation = $coursFind->option()->detach();
				
				foreach(Input::get('option') as $option_id){

					$coursFind->option()->attach($option_id);

				}

			}

			return Redirect::route('listerCours');
		}

		return Redirect::route('editerCours',$slug)
		->withInput()
		->withErrors($validation)
		->with('message', 'There were validation errors.');
		return View::make('gererMesCours.modifier');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function supprimer($slug)
	{
		$this->cours->where('slug',$slug)->delete();
		return Redirect::route('listerCours');
	}

}