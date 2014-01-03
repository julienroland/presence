<?php

class DeconnecterController extends BaseController {

	public function deconnecter()
	{
		Auth::logout();
		Session::forget('user');
		return Redirect::intended('/');
	}
}