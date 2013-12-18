@extends('layout.layout')

@section('container')
<div class="breadcrumbs">
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesGroupes','gérer mes groupes')}} > <span>editer le groupe {{$groupes->nom}}</span>
</div>
@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif
@if($groupes->count())

{{Form::open(array('method'=>'PATCH','url'=>array('gererMesGroupes/modifier',$groupes->slug)))}}

{{Form::label('nom','Le nom du groupe')}}
{{Form::text('nom',$groupes->nom,array('placeholder'=>'nom du groupe'))}}

{{Form::label('anneeLevel','En quelle année sont les membres du groupe')}}
{{Form::select('anneeLevel[]',$listAnneeLevel,$listHasAnneeLevel,array('multiple'=>true))}}

{{Form::label('option','En quelle option')}}
{{Form::select('option',$listOption,$groupes->options_id)}}

{{Form::label('cours','L\'ajouter à un ou des cours existant(s)')}}
{{Form::select('cours[]',$listCours,'',array('multiple'=>true))}}

{{Form::submit('envoyer')}}

{{Form::close()}}
@endif


@stop