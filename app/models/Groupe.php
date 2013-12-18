<?php

class Groupe extends Eloquent {
	protected $guarded = array();
	protected $table = 'groupe';
	public static $rules = array();

	public static $sluggable = array(
		'build_from' => 'nom',
		'save_to'    => 'slug',
		);
	public function eleve(){
		return $this->hasMany('Eleve','groupe_id');
	}

	public function cours(){
		return $this->belongsToMany('Cours','coursHasGroupe','groupe_id','cours_id');
	}

	public function option(){
		return $this->belongsTo('Option','options_id');
	}

	public function anneeLevel(){
		return $this->belongsToMany('AnneeLevel','groupeHasAnneeLevel','groupe_id','anneeLevel_id');
	}

	public function prof(){
		return $this->belongsTo('Prof','profs_id');
	}


}
