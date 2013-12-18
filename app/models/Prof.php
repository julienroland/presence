<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Prof extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('nom','prenom','email','password');
	
	public static $rules = array(
		'nom' => 'required|alpha',
		'prenom' => 'required|alpha',
		'email' => 'required|email|unique:profs',
		'password' => 'required',
		);
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'profs';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	public function anneeLevel(){

		return $this->belongsToMany('AnneeLevel');
	}

	public function cours(){

		return $this->belongsToMany('Cours','coursHasProfs','profs_id','cours_id');
	}

	public function groupe(){

		return $this->hasMany('Groupe','profs_id');
	}

	public static function rand($number)
	{
		return DB::table('profs')
					->select(DB::raw('RAND()'))
					->get($number);
	}
	public static function getGroupeAndCours($id){
		return DB::table('profs')
						->join('groupe','profs.id','=','groupe.profs_id')
						->join('anneeLevel','anneeLevel_id','=','anneeLevel.id')
						->join('options','options_id','=','options.id')
						->join('eleves','groupe.id','=','eleves.groupe_id')
						->join('coursHasGroupe','groupe.id','=','coursHasGroupe.groupe_id')
						->join('cours','coursHasGroupe.cours_id','=','cours.id')
						->whereProfsId($id)
						->get([
							'groupe.nom as groupe',
							'groupe.slug as groupeSlug',
							'options.id as optionId',
							'options.nom as option',
							'anneeLevel.id as anneeLevelId',
							'anneeLevel.nom as anneeLevel',
							'eleves.photo as elevePhoto',
							'eleves.prenom as elevePrenom',
							'eleves.nom as eleveNom',
							'eleves.slug as eleveSlug',
							'eleves.email as eleveEmail',
							]);
	}
	public static function getSceanceAndCours($id){
			return DB::table('profs')
						->join('coursHasProfs','profs.id','=','CoursHasProfs.profs_id')
						->join('cours','coursHasProfs.cours_id','=','cours.id')
						->join('coursHasGroupe','cours.id','=','coursHasGroupe.cours_id')
						->join('groupe','coursHasGroupe.groupe_id','=','groupe.id')
						->join('anneeLevel','cours.anneeLevel_id','=','anneeLevel.id')
						->join('coursHasOptions','cours.id','=','coursHasOptions.cours_id')
						->Join('options','coursHasOptions.options_id','=','options.id')						
						->join('sceances','cours.id','=','sceances.cours_id')
						->join('day','sceances.day_id','=','day.id')
						->where('profs.id','=',$id)
						->groupBy('sceances.id')
						->orderBy('sceances.date')
						->get([
							'options.id as optionId',
							'options.nom as option',
							'cours.id as coursId',
							'cours.nom as coursNom',
							'cours.duree as duree',
							'groupe.nom as groupe',
							'groupe.id as groupeId',
							'anneeLevel_id',
							'anneeLevel.nom as anneeLevel',
							'sceances.id as sceancesId',
							'sceances.date_start as debut',
							'sceances.date_end as fin',
							'sceances.date as date',
							'sceances.nb_semaine as semaine',
							'day.id as dayId',
							'day.nom as dayNom',
							]);
	}
	public static function getEleves($id){
		return DB::table('profs')
						->join('coursHasProfs','profs.id','=','CoursHasProfs.profs_id')
						->join('cours','coursHasProfs.cours_id','=','cours.id')
						->join('elevesHasCours','cours.id','=','elevesHasCours.cours_id')
						->join('eleves','elevesHasCours.eleves_id','=','eleves.id')
						->join('annees','annees_encours_id','=','annees.id')
						->join('anneeLevel','eleves.anneeLevel_id','=','anneeLevel.id')
						->join('groupe','eleves.groupe_id','=','groupe.id')
						->join('options','eleves.options_id','=','options.id')
						->where('profs.id','=',$id)
						->distinct()
						->get([
							'eleves.nom as nomEleve',
							'eleves.prenom as prenomEleve',
							'eleves.email as email',
							'eleves.photo as photo',
							'anneeLevel.nom as anneeLevel',
							'options.nom as option',
							'eleves.slug as slug',
							'eleves.groupe_id as groupe',
							'eleves.annees_encours_id as anneesEncours',


							]);
	}
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}