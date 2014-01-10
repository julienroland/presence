<?php

class IdentifierController extends BaseController {

	public function login()
	{

		$email = Input::get('email');
		$password = Input::get('password');

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
			
			return Redirect::to('/')
				->withInput()
				->withErrors($validation);
				
		}
		else
		{
			
			if(Auth::attempt(array('email'=>$email,'password'=>$password),true))
			{
				
				$prof = serialize(Auth::user());
				
				Session::put('user',$prof);
				Cookie::forever('connected', array('email'=>$email,'password'=>$password));
				return Redirect::to('index');
			}
			else
			{

				return Redirect::to('/')					
					->withInput()
					->withErrors($validation)
					->with('error','Votre compte n\'existe pas ou vous avez fait une erreur');
			}
		}
	}

}