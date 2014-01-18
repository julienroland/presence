	<?php

	use Carbon\Carbon;

	class GererSceancesController extends \BaseController {

		protected $sceance;

		public function __construct(Sceance $sceance)
		{
			$this->sceance = $sceance;
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
		
		$paramSceance = (object)array(
			'cours'=>Cours::get()->toArray(),
			'day'=>Day::get()->toArray(),

			);

		Session::put('paramSceance',$paramSceance);

		$sceances = Prof::getSceanceAndCours($id);
		
		
		/*$sceances = $prof->cours()->distinct()->with(array('sceance','sceance.day'))->with('option')->get()->toArray();*/

		return View::make('gererMesSceance.index')->with(compact('sceances'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function creer()
	{
		
		for($i=0;$i<=count(Session::get('paramSceance')->cours)-1;$i++)
		{
			$listCours[Session::get('paramSceance')->cours[$i]['slug']] = Session::get('paramSceance')->cours[$i]['slug'];

		}

		for($i=0;$i<=count(Session::get('paramSceance')->day)-1;$i++)
		{
			$listDay[Session::get('paramSceance')->day[$i]['nom']] = Session::get('paramSceance')->day[$i]['nom'];
		}
		return View::make('gererMesSceance.creer')
		->with(compact('listCours'))
		->with(compact('listDay'));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store()
	{
		$input= Input::all();
		
		$rules = array(
			'cours'=>'required',
			'jourX'=>'required',
			'jour'=>'required',
			'start'=>array('required','regex:/^[0-9]{1,2}\:[0-9]{2}/'),
			'end'=>array('required','regex:/^[0-9]{1,2}\:[0-9]{2}/'),
			'repetition'=>'required',
			'date'=>array('required','date','regex:/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}/'),
			);
		$validation = Validator::make($input, $rules);

		if ($validation->passes())
		{
			
			$dateExplode = explode('/',Input::get('date'));
			$dateWellFormated = $dateExplode[2].'-'.$dateExplode[1].'-'.$dateExplode[0];
			
			$coursId = Cours::whereSlug(Input::get('cours'))->lists('id');
			for($i=0;$i<=count(Input::get('jour'))-1;$i++){

				$dayId = Day::whereNom(ucWords(Input::get('jour')[$i]))->lists('id');

				$sceance = new Sceance(array(
					'cours_id'    => $coursId[0],
					'date_start'=>Input::get('start'),
					'date_end'=>Input::get('end'),
					'day_id'=>$dayId[0],
					'date'=>$dateWellFormated,
					));

				$sceance->save();
			}

			return Redirect::route('listerSceances');
		}

		return Redirect::route('creerSceances')
		->withInput()
		->withErrors($validation)
		->with('message', 'There were validation errors.');
	}
	public function getSceanceAjax( $id )
	{
		$sceance = Sceance::getCoursOfSceance($id);
		return json_encode($sceance);
	}
	public function creerAjax($data)
	{

		$dataExplode = explode('&',$data);
		
		$cours = explode('=',$dataExplode[1])[1]; 
		$start = explode('=',$dataExplode[2])[1]; 
		$end = explode('=',$dataExplode[3])[1]; 
		$repetition = explode('=',$dataExplode[4])[1]; 
		$temps = explode('=',$dataExplode[5])[1]; 
		$date = explode('=',$dataExplode[6])[1]; 
		$jour = explode('=',$dataExplode[7])[1]; 
		
		
		$input = array(
			'cours'=>$cours,
			'jour'=>$jour,
			'start'=>$start,
			'end'=>$end,
			'repetition'=>$repetition,
			'temps'=>$temps,
			'date'=>$date,
			);
		$rules = array(
			'cours'=>'required',
			'jour'=>'required',
			'start'=>array('required','regex:/^[0-9]{1,2}\:[0-9]{2}/'),
			'end'=>array('required','regex:/^[0-9]{1,2}\:[0-9]{2}/'),
			'repetition'=>'required',
			'temps'=>'required',
			'date'=>array('required','date'),
			);
		$validation = Validator::make($input, $rules);

		if ($validation->passes())
		{
			
			$coursId = Cours::whereSlug($cours)->lists('id');
			$dayId = Day::whereNom($jour)->lists('id');
			$howLong = intval($temps)+1;
			$eachWeek = intval($repetition)+1;
			$sceances = [];
			for($i=0;$i < $howLong ;$i+=$eachWeek){				

				$sceance = new Sceance(array(
					'cours_id'=> $coursId[0],
					'date_start'=>$start,
					'date_end'=>$end,
					'day_id'=>$dayId[0],
					'date'=>Carbon::createFromFormat('Y-m-d', $date)->addWeeks($i)->toDateString(),
					));

				$sceance->save();
				array_push($sceances,Sceance::getCoursOfSceance($sceance->id));


			}

			return json_encode($sceances);
		}


	}
	public function modifierAjax($data)
	{
		$dataExplode = explode('&',$data);
		$cours = explode('=',$dataExplode[1])[1];
		$date = explode('=',$dataExplode[2])[1];  
		$start = explode('=',$dataExplode[3])[1]; 
		$end = explode('=',$dataExplode[4])[1]; 
		$sceanceId = intval(explode('=',$dataExplode[5])[1]); 
		
		$date = Helpers::dateNaForm($date);
		
		$input = array(
			'cours'=>$cours,
			'date'=>$date,
			'start'=>$start,
			'end'=>$end,
			'sceance'=>$sceanceId,
			);
		$rules = array(
			'cours'=>'required',
			'date'=>'required|date',
			'start'=>array('required','regex:/^[0-9]{1,2}\:[0-9]{2}/'),
			'end'=>array('required','regex:/^[0-9]{1,2}\:[0-9]{2}/'),
			'sceance'=>'required|numeric',
			);

		$validation = Validator::make($input, $rules);

		if ($validation->passes())
		{
			$coursId = Cours::whereSlug($cours)->lists('id');
			$sceance = Sceance::find($sceanceId);
			$dateCarbon = Helpers::createCarbonDate($date);
			$jour = Helpers::humanDay($dateCarbon->dayOfWeek);
			$dayId = Day::whereNom($jour)->lists('id');
			
			$sceance->update( array(
				'cours_id'=>$coursId[0],
				'day_id'=>$dayId[0],
				'date'=>$date,
				'date_start'=>$start,
				'date_end'=>$end,
				));
			$sceanceAndCours = Sceance::getCoursOfSceance($sceance->id);
			return json_encode($sceanceAndCours);
		}


	}	
	public function supprimerAjax($data)
	{
		$dataExplode = explode('&',$data);
		$id = explode('=',$dataExplode[1])[1];

		$sceance = Sceance::find($id)->delete();
		if($sceance){
			return json_encode($id);
		}
		else{
			return false;
		}

	}	

/**
* Display the specified resource.
*
* @param  int  $id
* @return Response
*/
public function voir($id)
{

	$sceance = Sceance::find($id)->with('cours.groupe','day')->first();

	$listPresence = Presence::orderBy('id','desc')->get();

	

	foreach($sceance->cours->groupe as $groupe){

		$listGroupeId[$groupe->id] = $groupe->id; //id des groupes
		
		$listGroupe[$groupe->id] = (object)['id'=>$groupe->id ,'nom'=>$groupe->nom]; //id et nom des groupes

	}
	
	$presences = Sceance::getPresence($id);
	
	//PRESENCE TOTAL
	$pourcentagePresence = BaseController::toPercent(Sceance::getPresenceSceance($id) , Sceance::getTotalPresenceSceance($id));

	//PRESENCE PAR GROUPE
	foreach($listGroupe as $groupe){

		$presenceGroupe[] = (object)[
		'id'=>$groupe->id , 
		'nom'=>$groupe->nom , 
		'percent'=> BaseController::toPercent( Sceance::getPresenceGroupe($id , $groupe->id),Sceance::getTotalPresenceGroupe($id , $groupe->id))
		];
	}
	
	$dateWellFormated = BaseController::dateEu($sceance->date);

	$listGroupeIdJson = json_encode($listGroupeId);
	$listGroupeJson = json_encode($presenceGroupe);
	
	return View::make('gererMesSceance.voir', compact('sceance'))
	->with(compact('dateWellFormated'))
	->with(compact('listPresence'))
	->with(compact('listGroupeIdJson'))
	->with(compact('listGroupeJson'))
	->with(compact('presences'))
	->with(compact('presenceGroupe'))
	->with(compact('pourcentagePresence'));
}

/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return Response
*/
public function editer($id)
{
	$sceances = Sceance::find($id);
	
	if (is_null($sceances))
	{
		return Redirect::route('gererMesSceance.index');
	}
	

	for($i=0;$i<=count(Session::get('paramSceance')->cours)-1;$i++)
	{
		$listCours[Session::get('paramSceance')->cours[$i]['id']] = Session::get('paramSceance')->cours[$i]['slug'];
		
	}
	
	

	for($i=0;$i<=count(Session::get('paramSceance')->day)-1;$i++)
	{
		$listDay[Session::get('paramSceance')->day[$i]['id']] = Session::get('paramSceance')->day[$i]['nom'];
	}

	return View::make('gererMesSceance.editer')
	->with(compact('sceances'))
	->with(compact('listCours'))
	->with(compact('listDay'));
}

/**
* Update the specified resource in storage.
*
* @param  int  $id
* @return Response
*/
public function modifier($id)
{

	$input= array(
		'cours'=>Input::get('cours'),
		'jour'=>Input::get('jour'),
		'heure du début'=>Input::get('debut'),
		'heure de fin'=>Input::get('fin'),
		);

	$validation = Validator::make($input, Sceance::$rules);

	if ($validation->passes())
	{

		$sceance = Sceance::find($id);
		$cours = Cours::whereSlug(Input::get('cours'))->first(['id']);
		$coursId = $cours->id;
		$eleves = $cours->eleve()->get();
		$presenceId = 0;
		foreach($eleves as $eleve)
		{
			$elevesId[$eleve->id] = $eleve->id;
		}
		
		$dayId = Day::whereNom(ucWords(Input::get('jour')))->lists('id');
		
		$sceance->update( array(
			'cours_id'=>$coursId[0],
			'day_id'=>$dayId[0],
			'date_start'=>Input::get('debut'),
			'date_end'=>Input::get('fin'),
			));
		

		$sceance->eleve()->detach();
		
		foreach($elevesId as $eleveId)
		{
			$sceance->eleve()->attach(array('eleves_id'=>$eleveId), array('presence_id'=>$presenceId));

		}
		
		return Redirect::route('voirSceances', $id);
	}

	return Redirect::route('editerSceances',$id)
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
public function supprimer($id)
{
	$sceance = Sceance::find($id)->delete();
	if($sceance)
	{
		return Redirect::route('listerSceances')
		->with('success','Scéance bien supprimée !');
	}
	else
	{
		return Redirect::route('listerSceances')
		->with('error', 'La suppression à échouée, vérifier que la scéance existe toujours bien (F5).');
	}
}

}