@extends('layout.layout')

@section('container')
<div class="breadcrumbs">
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesEleves','gérer mes élèves')}} > <span>voir {{$eleve->prenom}} {{$eleve->nom}}</span>
</div>

@if($eleve->count())
<img src='{{$eleve->photo}}'/>
<p>
	{{$eleve->nom}}
</p>
<p>
	{{$eleve->prenom}}
</p>
<p>
	{{$eleve->email}}
</p>

<p>
	{{$eleve->groupe_id}}
</p>
<p>
	{{$eleve->anneeLevel->nom}}
</p><p>
{{$eleve->groupe->option->nom}}
</p>
@endif
@stop