@extends('layout.layout')

@section('container')
<div class="breadcrumbs">
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesEleves','gérer mes élèves')}} > <span>editer {{$eleve->prenom}} {{$eleve->nom}}</span>
</div>
@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif
@if($eleve->count())

{{Form::open(array('method'=>'PATCH','url'=>array('gererMesEleves/modifier',$eleve->slug)))}}
{{Form::label('prenom','Le prénom de l\'élève')}}
{{Form::text('prenom',$eleve->prenom,array('placeholder'=>'John'))}}

{{Form::label('nom','Le nom de l\'élève')}}
{{Form::text('nom',$eleve->nom,array('placeholder'=>'Doe'))}}

{{Form::label('email','L\'email de l\'élève')}}
{{Form::email('email',$eleve->email,array('placeholder'=>'John'))}}

{{Form::label('photo','La photo l\'élève')}}
{{Form::file('photo','')}}

{{Form::label('groupe','Le groupe de l\'élève')}}
{{Form::select('groupe',$listGroupe,$eleve->groupe_id)}}

{{Form::label('annee','L\'année en cours')}}
{{Form::select('annee',$listAnnee,$eleve->annees_encours_id)}}

{{Form::label('anneeLevel','En quel année est-il')}}
{{Form::select('anneeLevel',$listAnneeLevel,$eleve->anneeLevel_id)}}

{{Form::label('option','En quelle option')}}
{{Form::select('option',$listOption,$eleve->options_id)}}

{{Form::label('cours','L\'ajouter à un ou des cours existant(s)')}}
{{Form::select('cours[]',$listCours,'',array('multiple'=>true))}}

{{Form::submit('envoyer')}}

{{Form::close()}}
@endif


@stop