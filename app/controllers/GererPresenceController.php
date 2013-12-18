<?php

class GererPresenceController extends BaseController {


	public function modifier($idPresence, $idEleve, $idSceance)
	{
		
		$eleve = Eleve::find($idEleve);

		$date = new \DateTime;

		$pivot = $eleve->sceance()->update(array(

			'presence_id'=>$idPresence,
			
			));
		if($pivot)
		{
			$presence = Sceance::getPresenceEleve($idSceance, $idEleve);
			return json_encode($presence);
		}	

	}

	public function updateTotalPourcentage( $idSceance ){

		$pourcentagePresence = BaseController::toPercent(Sceance::getPresenceSceance( $idSceance ) , Sceance::getTotalPresenceSceance( $idSceance ));
		
		return json_encode($pourcentagePresence);
	}

	public function updateGroupePourcentage( $idSceance ){
		$sceance = Sceance::find($idSceance)->with('cours.groupe','day')->first();

		foreach($sceance->cours->groupe as $groupe){

		$listGroupe[$groupe->id] = (object)['id'=>$groupe->id ,'nom'=>$groupe->nom]; //id et nom des groupes

	}
	foreach($listGroupe as $groupe){

		$presenceGroupe[] = (object)['id'=>$groupe->id,'nom'=>$groupe->nom , 'percent'=> BaseController::toPercent( Sceance::getPresenceGroupe($idSceance , $groupe->id),Sceance::getTotalPresenceGroupe($idSceance , $groupe->id))];
	}

	return json_encode($presenceGroupe);
}

}