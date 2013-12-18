<?php

class Presence extends Eloquent {
	protected $guarded = array();
	protected $table = 'presence';
	public static $rules = array();

	public function sceanceHasEleve(){
		return $this->hasMany('SceancesHasEleves');
	}
}
