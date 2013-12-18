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
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesSceances','Gerer mes scéance')}} > <span>{{('créer une scéance')}} </span>
</div>



{{Form::open(array('route'=>'gererMesSceances.index'))}}

{{Form::label('cours','Pour le cours')}}
{{Form::select('cours',$listCours)}} 

{{Form::label('jourX','Nombre de fois par semaine')}}
{{Form::select('jourX',array(
'1'=>'1',
'2'=>'2',
'3'=>'3',
'4'=>'4',
'5'=>'5',
))}} 

{{Form::label('jour','Pour le')}}
{{Form::select('jour[]',$listDay,'',array('multiple' => true))}} 

{{Form::label('start','commence à')}}
{{Form::text('start','',array('placeholder'=>'au format: h:m ex: 5:30'))}}

{{Form::label('end','fini à')}}
{{Form::text('end','',array('placeholder'=>'au format: h:m ex: 5:30'))}}


{{Form::label('repetition','Toute les')}}
{{Form::select('repetition',array(
'1'=>'1',
'2'=>'2',
'3'=>'3',
'4'=>'4',
))}} {{('semaine(s)')}}
 
{{Form::label('date','A partir du ')}}
{{Form::text('date','',array('placeholder'=>'au format: jj/mm/yyyy ex: 28/02/1992'))}}

{{Form::submit('créer')}}

{{Form::close()}}

@stop