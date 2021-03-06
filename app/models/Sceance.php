<?php

class Sceance extends Eloquent {
	protected $guarded = array();
	protected $table = 'sceances';
	public static $rules = array(
		'heure du début'=>array('required','regex:/^[0-9]{1,2}\:[0-9]{2}/'),
		'heure de fin'=>array('required','regex:/^[0-9]{1,2}\:[0-9]{2}/'),
		'cours'=>'required:|exists:cours,slug',
		'jour'=>'required|exists:day,nom',
		);

	public function eleve(){
		return $this->belongsToMany('Eleve','sceancesHasEleves','sceances_id','eleves_id')
		->withPivot('presence_id','commentaire')
		->withTimestamps();


	}
	public function cours(){
		return $this->belongsTo('Cours','cours_id');

	}
	public function day(){
		return $this->belongsTo('Day','day_id');

	}
	public static function getSceanceEleves($sceance_id){
		return DB::table('sceances')
		->join('cours','sceances.cours_id','=','cours.id')
		->join('elevesHasCours','cours.id','=','elevesHasCours.cours_id')
		->join('eleves','elevesHasCours.eleves_id','=','eleves.id')
		->where('sceances.id','=',$sceance_id)
		->distinct()
		->get([
			'eleves.nom as nomEleve',
			'eleves.prenom as prenomEleve',
			'eleves.email as email',
			'eleves.photo as photo',
			'anneeLevel.nom as anneeLevel',
			'options.nom as option',
			'eleves.slug as slug',
			'eleves.groupe_id as groupe',
			'eleves.annees_encours_id as anneesEncours',


			]);
	}
	public static function countPresence($sceance_id){
		return DB::table('sceances')
		->join('sceancesHasEleves','sceances.id','=','sceancesHasEleves.sceances_id')
		->where('sceances.id','=',$sceance_id)
		->where('sceancesHasEleves.presence_id','=','3')
		->count('sceancesHasEleves.presence_id');
	}
	public static function getCoursOfSceance($sceance_id){
		return DB::table('sceances')
		->join('cours','sceances.cours_id','=','cours.id')
		->join('day','sceances.day_id','=','day.id')
		->where('sceances.id','=',$sceance_id)
		->first([
			'sceances.id as sceanceId',
			'sceances.date_start as date_start',
			'sceances.date_end as date_end',
			'sceances.date as date',
			'day.nom as day',
			'cours.nom as cours',
			'cours.anneeLevel_id as anneeLevel',
			'cours.duree as duree',
			'cours.slug as coursSlug',
			]);

	}
	public static function getPresence($id ){
		return DB::table('sceances')
		->join('sceancesHasEleves','sceances.id','=','sceancesHasEleves.sceances_id')
		->join('eleves','sceancesHasEleves.eleves_id','=','eleves.id')
		->join('groupe','eleves.groupe_id','=','groupe.id')
		->join('presence','sceancesHasEleves.presence_id','=','presence.id')
		->whereSceancesId($id)			
		->get([
			'eleves.prenom as prenom',
			'eleves.nom as nom',
			'eleves.photo as photo',
			'eleves.slug as eleveSlug',
			'eleves.id as eleveId',
			'sceances.id as sceanceId',
			'groupe.id as groupeId',
			'groupe.nom as groupe',
			'presence.id as presenceId',
			'presence.type as presence',

			]);
	}
	public static function getPresenceSceance($id){

		return DB::table('sceances')
		->join('cours','sceances.cours_id','=','cours.id')
		->join('coursHasGroupe','cours.id','=','coursHasGroupe.cours_id')
		->join('groupe','coursHasGroupe.groupe_id','=','groupe.id')
		->join('sceancesHasEleves','sceances.id','=','sceancesHasEleves.sceances_id')
		->join('presence','sceancesHasEleves.presence_id','=','presence.id')
		->whereSceancesId($id)
		->where('sceancesHasEleves.presence_id','=','3')
		->distinct()
		->count('sceancesHasEleves.eleves_id');
	}
	public static function getTotalPresenceSceance($id){

		return DB::table('sceances')
		->join('cours','sceances.cours_id','=','cours.id')
		->join('coursHasGroupe','cours.id','=','coursHasGroupe.cours_id')
		->join('groupe','coursHasGroupe.groupe_id','=','groupe.id')
		->join('sceancesHasEleves','sceances.id','=','sceancesHasEleves.sceances_id')
		->join('presence','sceancesHasEleves.presence_id','=','presence.id')
		->whereSceancesId($id)
		->distinct()
		->count('sceancesHasEleves.eleves_id');
	}
	public static function getTotalPresenceGroupe($id, $groupeId){

		return DB::table('sceances')
		->join('cours','sceances.cours_id','=','cours.id')
		->join('coursHasGroupe','cours.id','=','coursHasGroupe.cours_id')
		->join('groupe','coursHasGroupe.groupe_id','=','groupe.id')
		->join('sceancesHasEleves','sceances.id','=','sceancesHasEleves.sceances_id')
		->join('presence','sceancesHasEleves.presence_id','=','presence.id')
		->whereSceancesId($id)
		->where('sceancesHasEleves.groupe_id',$groupeId)
		->distinct()
		->count('sceancesHasEleves.eleves_id');
	}
	public static function getPresenceGroupe($id, $groupeId){

		return DB::table('sceances')
		->join('cours','sceances.cours_id','=','cours.id')
		->join('coursHasGroupe','cours.id','=','coursHasGroupe.cours_id')
		->join('groupe','coursHasGroupe.groupe_id','=','groupe.id')
		->join('sceancesHasEleves','sceances.id','=','sceancesHasEleves.sceances_id')
		->join('presence','sceancesHasEleves.presence_id','=','presence.id')
		->whereSceancesId($id)
		->where('sceancesHasEleves.groupe_id',$groupeId)
		->where('sceancesHasEleves.presence_id','3')
		->distinct()
		->count('sceancesHasEleves.eleves_id');
	}

	public static function getPresenceEleve($sceanceId, $eleveId){
		return DB::table('sceances')
		->join('sceancesHasEleves','sceances.id','=','sceancesHasEleves.sceances_id')
		->join('eleves','sceancesHasEleves.eleves_id','=','eleves.id')
		->join('groupe','eleves.groupe_id','=','groupe.id')
		->join('presence','sceancesHasEleves.presence_id','=','presence.id')
		->where('sceances.id','=',($sceanceId))
		->where('eleves.id','=',($eleveId))
		->first([
			'eleves.prenom as prenom',
			'eleves.nom as nom',
			'eleves.photo as photo',
			'eleves.slug as eleveSlug',
			'eleves.id as eleveId',
			'sceances.id as sceanceId',
			'groupe.id as groupeId',
			'groupe.nom as groupe',
			'presence.id as presenceId',
			'presence.type as presence',

			]);

	}
}
