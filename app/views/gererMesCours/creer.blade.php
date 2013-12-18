@extends('layout.layout')

@section('container')

@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif

<div class="breadcrumbs">
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesCours','Gerer mes cours')}} > <span>{{('créer un cours')}} </span>
</div>




{{Form::open(array('route'=>'gererMesCours.index'))}}


{{Form::label('nom','Intitulé')}}
{{Form::text('nom','',array('placeholder'=>'Entrez l\'intitulé du cours','id'=>'nom'))}}


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
	))}} <span>Heure(s)</span>	

	
	{{Form::label('anneeLevel','Année d\'étude')}}
	{{Form::select('anneeLevel',$listAnneeLevel)}} <span>Année</span>

	{{Form::label('option','de l\'option' )}}
	{{Form::select('option[]',$listOption,'',array('multiple'=>true))}}

	{{Form::label('groupe','du groupe')}}
	{{Form::select('groupe[]',$listGroupe,'',array('multiple' => true))}}  

	{{Form::submit('créer')}}

	{{Form::close()}}

	@stop