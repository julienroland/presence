<?php

class Cours extends Eloquent {
	protected $guarded = array();
	protected $table = 'cours';
	public static $rules = array(
		'intitulé' => 'required',
		'duree' => 'required',
		'année étude' => 'required',
		'options' => 'required',
		'groupe' => 'required',
		);

	public static $sluggable = array(
		'build_from' => 'nom',
		'save_to'    => 'slug',
		'unique'     => true,
		);

	public function anneeLevel(){
		return $this->belongsTo('AnneeLevel','anneeLevel_id');
	}

	public function prof(){
		return $this->belongsToMany('Prof','coursHasProfs','cours_id','profs_id');
	}

	public function groupe(){
		return $this->belongsToMany('Groupe','coursHasGroupe','cours_id','groupe_id');
	}

	public function eleve(){
		return $this->belongsToMany('Eleve','elevesHasCours','cours_id','eleves_id');
	}

	public function option(){
		return $this->belongsToMany('Option','coursHasOptions','cours_id','options_id');
	}
	public function sceance(){
		return $this->hasMany('Sceance','cours_id');
	}
}
