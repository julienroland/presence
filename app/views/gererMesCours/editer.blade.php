@extends('layout.layout')

@section('container')

<div class="breadcrumbs">
@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesCours','Gerer mes cours')}} > <span>{{('editier le cours de')}} {{$cours->nom}}</span>
</div>

@if($cours->count())

	{{Form::open(array('method'=>'PATCH','url'=>array('gererMesCours/modifier',$cours->slug)))}}


	{{Form::label('nom','Intitulé')}}
	{{Form::text('nom',$cours->nom,array('placeholder'=>'Entrez l\'intitulé du cours','id'=>'nom'))}}

	{{Form::label('duree','Durée')}}
	{{Form::select('duree',array(
	'1'=>'1',
	'2'=>'2',
	'3'=>'3',
	'4'=>'4',
	'5'=>'5',
	'6'=>'6',
	'7'=>'7',
	'8'=>'8'
	),$cours->duree)}} <span>Heure(s)</span>	

	{{Form::label('anneeLevel','Aux élèves de')}}
	{{Form::select('anneeLevel',$listAnneeLevel,$cours->anneeLevel->id)}} <span>Année</span>

	{{Form::label('option','de l\'option' )}}
	{{Form::select('option[]',$listOption,$listHasOption,array('multiple'=>true))}}

	 {{Form::label('groupe','du groupe')}}
	{{Form::select('groupe[]',$listGroupe,$listHasGroupe,array('multiple' => true))}}  

	{{Form::submit('modifier')}}

	{{Form::close()}}

	@endif
	@stop