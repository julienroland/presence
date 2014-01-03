<?php

class IdentifierController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function login()
	{
		$email = Input::get('email');
		$password = Input::get('mdp');

		$validation = Validator::make(
			array(
				'password' => $password,
				'email' => $email
				),
			array(
				'password' => 'required|min:3',
				'email' => 'required|email|exists:profs'
				)
			);

		if ($validation->fails())
		{
			
			return Redirect::to('/#connexion')
				->withInput()
				->withErrors($validation);
				
		}
		else
		{
			
			if(Auth::attempt(array('email'=>$email,'password'=>$password),true))
			{
				
				$prof= Auth::user();
				
				Session::put('user',$prof);
	
				Cookie::forever('connected', array('email'=>$email,'password'=>$password));
				return Redirect::to('/');
			}
			else
			{

				return Redirect::to('/#connexion')					
					->withInput()
					->withErrors($validation)
					->with('error','Votre compte n\'existe pas ou vous avez fait une erreur');
			}
		}
	}

}