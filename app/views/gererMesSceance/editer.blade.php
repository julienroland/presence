@extends('layout.layout')

@section('container')

<div class="breadcrumbs">
	
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesSceances','Gerer mes sceances')}} > <span>{{('editier la sceance du')}} {{BaseController::dateEu($sceances->date)}} {{('à')}} {{$sceances->date_start}}</span>
</div>

@if ($errors->any())
<div class="errors">
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
</div>
@endif

@if($sceances->count())

{{Form::open(array('method'=>'PATCH','url'=>array('gererMesSceances/modifier',$sceances->id)))}}

{{Form::label('cours','Pour quel cours')}}
{{Form::select('cours',$listCours,$sceances->cours_id)}}

{{Form::label('jour','Pour quel jour')}}
{{Form::select('jour',$listDay,$sceances->day_id)}}

{{Form::label('debut','Heure du début')}}
{{Form::text('debut',$sceances->date_start,array('placeholder'=>'Format: 5:32'))}}

{{Form::label('fin','Heure de fin')}}
{{Form::text('fin',$sceances->date_end,array('placeholder'=>'Format: 16:30'))}}



{{Form::submit('modifier')}}

{{Form::close()}}
@endif
@stop