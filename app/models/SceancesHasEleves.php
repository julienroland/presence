<?php

class SceancesHasEleves extends Eloquent {
	protected $guarded = array();

	public static $rules = array();
	$sceance = Sceance::find(1);
	$sceance->eleve()->attach($id, 'presence_id');
	public function presence(){

		return $this->hasOne('Presence');
	
	}
	public function sceance(){

		return $this->belongsToMany('Sceance');
	
	}
	public function eleve(){

		return $this->belongsToMany('Eleve');
	
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
}
