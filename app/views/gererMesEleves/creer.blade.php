@extends('layout.layout')

@section('container')
<div class="breadcrumbs">
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesEleves','gérer mes élèves')}} > <span>créer un nouvel élève</span>
</div>
@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif



{{Form::open(array('route'=>'gererMesEleves.index'))}}
{{Form::label('prenom','Le prénom de l\'élève')}}
{{Form::text('prenom','',array('placeholder'=>'John'))}}

{{Form::label('nom','Le nom de l\'élève')}}
{{Form::text('nom','',array('placeholder'=>'Doe'))}}

{{Form::label('email','L\'email de l\'élève')}}
{{Form::email('email','@student.hepl.be',array('placeholder'=>'John'))}}

{{Form::label('photo','La photo l\'élève')}}
{{Form::file('photo','')}}

{{Form::label('groupe','Le groupe de l\'élève')}}
{{Form::select('groupe',$listGroupe)}}

{{Form::label('annee','L\'année en cours')}}
{{Form::select('annee',$listAnnee)}}

{{Form::label('anneeLevel','En quel année est-il')}}
{{Form::select('anneeLevel',$listAnneeLevel)}}

{{Form::label('option','En quelle option')}}
{{Form::select('option',$listOption,$listOption['1'])}}

{{Form::label('cours','L\'ajouter à un ou des cours existant(s)')}}
{{Form::select('cours[]',$listCours,'',array('multiple'=>true))}}

{{Form::submit('envoyer')}}

{{Form::close()}}



@stop