<?php

use Carbon\Carbon;

class HomeController extends BaseController {

	public function index()
	{
		$title="Accueil";
		$head="Page d'accueil de l'application présence";

		$user = unserialize(Session::get('user'));
		$date = date("Y-m-d");
		$prof = Prof::find($user->id);
		$sceances = Prof::getSceanceAndCours($user->id);
		//cours
		$cours = $prof->cours;

		//sceance
		foreach($sceances as $sceance){
			$date = Helpers::createCarbonDate($sceance->date); 
			
			if($date->isToday()){

				$sceance = $sceance;
				$presence = Sceance::countPresence($sceance->sceancesId);
			}
			else
			{
				$sceance = NULL;
				$presence = NULL;
			}
		}

		$paramSceanceHome = (object)array(
			'cours'=>Cours::get()->toArray(),
			'day'=>Day::get()->toArray(),

			);


		for($i=0;$i<=count($paramSceanceHome->cours)-1;$i++)
		{
			$listCours[$paramSceanceHome->cours[$i]['slug']] = $paramSceanceHome->cours[$i]['slug'];

		}
		for($i=0;$i<=count($paramSceanceHome->day)-1;$i++)
		{
			$listDay[$paramSceanceHome->day[$i]['nom']] = $paramSceanceHome->day[$i]['nom'];
		}

		return View::make('indexlog')->with(compact('title','head','presence','sceance','cours','listCours','listDay'));

	}
}
