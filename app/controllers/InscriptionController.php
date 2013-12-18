<?php

class InscriptionController extends BaseController {

	protected $prof;

	public function __construct(Prof $prof)
	{
		$this->prof = $prof;
	}
	public function index()
	{

		return View::make('inscription');
	}
	public function creer()
	{
		$input= Input::all();

		$validation = Validator::make($input, Prof::$rules);

		if ($validation->passes())
		{

			$prof = new Prof(array(
				'nom'    => Input::get('nom'),
				'prenom'=>Input::get('prenom'),
				'email'=> Input::get('email'),
				'password'=>Hash::make(Input::get('mdp')),
			
				));

			$prof->save();
		
			return Redirect::to('/')
				->withInput()
				->with('messageOk','Vous êtes bien inscrit !');
		}

		return Redirect::route('inscription')
		->withInput()
		->withErrors($validation)
		->with('message', 'There were validation errors.');
		
	}

}