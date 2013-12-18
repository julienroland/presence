<?php

class AnneeLevel extends Eloquent {
	protected $guarded = array();
	protected $table = 'anneeLevel';
	public static $rules = array();
	public function prof()
	{
		return $this->belongsToMany('Prof');
	}

	public function cours()
	{
		return $this->hasMany('Cours','anneeLevel_id');
	}

	public function groupe()
	{
		return $this->belongsToMany('Groupe','groupeHasAnneeLevel','anneeLevel_id','groupe_id');
	}

	public function option()
	{
		return $this->belongsToMany('Option','optionsHasAnneeLevel','anneeLevel_id','options_id');
	}
}
