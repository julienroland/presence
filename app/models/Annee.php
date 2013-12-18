<?php

class Annee extends Eloquent {
	protected $guarded = array();

	protected $table = 'annees';
	public function eleve(){
		return $this->belongsToMany('Eleve');
	}
	public static $rules = array();
}
