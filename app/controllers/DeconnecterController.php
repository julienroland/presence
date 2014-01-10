<?php

class DeconnecterController extends \BaseController {

	public function index()
	{
		Auth::logout();
		Session::forget('user');
		return Redirect::to('/');
	}
}