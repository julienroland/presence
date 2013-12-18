@extends('layout.layout')

@section('container')
<div class="breadcrumbs">
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesGroupes','gérer mes groupes')}} > <span>créer un groupe </span>
</div>
@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif


{{Form::open(array('route'=>'gererMesGroupes.index'))}}

{{Form::label('nom','Le nom du groupe')}}
{{Form::text('nom','',array('placeholder'=>'nom du groupe'))}}

{{Form::label('anneeLevel','En quelle année sont les membres du groupe')}}
{{Form::select('anneeLevel[]',$listAnneeLevel,'',array('multiple'=>true))}}

{{Form::label('option','En quelle option')}}
{{Form::select('option',$listOption)}}

{{Form::label('cours','L\'ajouter à un ou des cours existant(s)')}}
{{Form::select('cours[]',$listCours,'',array('multiple'=>true))}}

{{Form::submit('envoyer')}}

{{Form::close()}}



@stop