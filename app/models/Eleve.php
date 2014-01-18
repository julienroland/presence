<?php

class Eleve extends Eloquent {
	protected $guarded = array();

	protected $table = 'eleves';

	public static $rules = array(
		'nom'=>'required|regex:/^([a-z\x20])+$/i',
		'prenom'=>'required|alpha',
		'email'=>'required|email|unique:eleves',
		'groupe_id'=>'required|numeric',
		'photo'=>'',
		'annees_encours_id'=>'required|numeric',
		'anneeLevel_id'=>'required|numeric',
		'options_id'=>'required|numeric',

		);

	public static $sluggable = array(
		'build_from' => 'fullname',
		'save_to'    => 'slug',
		);

	public function getFullnameAttribute() {
		return $this->prenom . ' ' . $this->nom;
	}

	public function annee(){

		return $this->belongsToMany('Annee');

	}
	public function cours(){

		return $this->belongsToMany('Cours','elevesHasCours','eleves_id','cours_id');

	}
	public function groupe(){

		return $this->belongsToMany('Groupe','elevesHasGroupe','eleves_id','groupe_id');

	}
	public function anneeLevel(){

		return $this->belongsTo('AnneeLevel','anneeLevel_id');

	}
	public function option(){

		return $this->belongsTo('Options','options_id');

	}
	public function sceance(){

		return $this->belongsToMany('Sceance','sceancesHasEleves','eleves_id','sceances_id')
			->withPivot('presence_id','commentaire')
			->withTimestamps();


	}
}
