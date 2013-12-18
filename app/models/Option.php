<?php

class Option extends Eloquent {
	protected $guarded = array();
	protected $table = 'options';
	public static $rules = array();
	public function cours(){

		return $this->belongsToMany('Cours','coursHasOptions','options_id','cours_id');
	}
	public function anneeLevel(){
		return $this->belongsToMany('AnneeLevel','optionsHasAnneeLevel','options_id','anneeLevel_id');
	}
	public function groupe(){
		return $this->hasMany('Groupe','options_id');
	}
	public function eleve(){
		return $this->hasMany('Eleve','options_id');
	}
}
