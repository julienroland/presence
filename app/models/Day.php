<?php

class Day extends Eloquent {
	protected $guarded = array();
	protected $table = 'day';
	public static $rules = array();

	public function sceance()
	{
		return $this->hasMany('Sceance','day_id');
	}
}
