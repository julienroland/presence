@extends('layout.layout')

@section('container')
@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif
{{Form::open(array('url'=>'inscription/creer'))}}

{{Form::label('nom','Entrez votre nom')}}
{{Form::text('nom','',array('placeholder'=>'Nom'))}}

{{Form::label('prenom','Entrez votre prénom')}}
{{Form::text('prenom','',array('placeholder'=>'Prenom'))}}

{{Form::label('email','Entrez votre email')}}
{{Form::email('email','',array('placeholder'=>'Email'))}}

{{Form::label('password','Entrez votre mot de passe')}}
{{Form::password('password','')}}

{{Form::label('photo','Ajouter une photo')}}
{{Form::password('photo','')}}

{{Form::submit('S\'inscrire')}}
{{Form::close()}}
@stop