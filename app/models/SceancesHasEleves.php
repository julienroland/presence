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
}
