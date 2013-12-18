@extends('layout.layout')

@section('container')
<div class="breadcrumbs">
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesGroupes','gérer mes groupes')}} > <span>voir {{$groupe->nom}}</span>
</div>

@if($groupe->count())

<p>
	{{$groupe->nom}}
</p>
<p>
	{{$groupe->option->nom}}
</p>

@foreach($groupe->anneeLevel as $anneeLevel)
<p>
	{{$anneeLevel->nom}}
</p>
@endforeach

@if($groupe->eleve->count())
<p>Liste de(s) élève(s) appartenant au groupe</p>
@foreach($groupe->eleve as $eleve)

<img src="{{$eleve->photo}} " alt="">
<p>
	{{link_to_route('voirEleves',$eleve->prenom.' '.$eleve->nom,$eleve->slug,array('title'=>'Voir la fiche de '.$eleve->prenom.' '.$eleve->nom))}} 
</p>
<p>
	{{$eleve->email}} 
</p>
@endforeach
@else
<p>Aucun élève appartient au groupe</p>

@endif

@if($groupe->cours->count())
<p>Liste de(s) cours appartenant au groupe</p>
@foreach($groupe->cours as $cours)

<p>
	{{('cours de')}} {{$cours->nom}}
</p>
<p>
	{{('d\'une durée')}} {{$cours->duree}}
</p>

@endforeach
@else
<p>Aucun cours appartient au groupe</p>

@endif
@endif
@stop