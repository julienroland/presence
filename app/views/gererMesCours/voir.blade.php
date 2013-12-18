@extends('layout.layout')

@section('container')
<div class="breadcrumbs">
	@if ($errors->any())
	<div class="errors">
		<ul>
			{{ implode('', $errors->all('<li class="error">:message</li>')) }}
		</ul>
	</div>
	@endif
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesCours','Gerer mes cours')}} > <span>{{('Voir le cours de')}} {{$cours->nom}}</span>
</div>

@if($cours->count())
<p>
	{{('Je donne cours de')}} {{$cours->nom}} {{('au étudiant de')}} {{$cours->anneeLevel_id}}<sup>e</sup>{{(' année')}} 
	
	@if($cours->option->count())
	
	@foreach($cours->option as $option)

	{{('de l\'option')}} {{$option->nom}}

	@endforeach
	@endif

	@if($cours->groupe->count())
	<?php $i=0; ?>
	@foreach($cours->groupe as $groupe)
	
	{{('au(x) groupe(s)')}} {{$groupe->nom}}
	<?php $i++; ?>
	@if( $cours->groupe->count() > $i && $cours->groupe->count()>1)
	{{('et')}}
	@endif
	
	@endforeach
	@endif

	{{('pendant une durée de')}} {{$cours->duree}} {{('heure(s)')}}
</p>


@if($cours->eleve->count())
<p>
	{{('Liste des élèves du cours')}}
	<ul>
		@foreach($cours->eleve as $eleve)
	
		<li>{{link_to_route('voirEleves',$eleve->prenom.' '.$eleve->nom,$eleve->slug)}} {{('appartenant au groupe ')}}{{$eleve->groupe->nom}}</li>

		@endforeach
	</ul>
</p>
@endif

@if($cours->eleve->count())

<p>
	{{('Liste des scéances à venir')}}
	<ul>
		@foreach($cours->sceance as $sceance)

		<?php 
		$dateExplode = explode('-',$sceance->date)
		
		?>
		
		@if(date('Y') <= $dateExplode[0] && date('m')<= $dateExplode[1] && date('d') <= $dateExplode[2])
		<?php $dateEu = $dateExplode[2].'/'.$dateExplode[1].'/'.$dateExplode[0]; ?>

		<li>{{link_to_route('voirSceances',$dateEu,$sceance->id)}}
			@for($i=0;$i<=count($sceance->cours['groupe'])-1;$i++)
			{{$sceance->cours->groupe[$i]->nom}}
			@endfor
		</li>
		@else
		<p>Aucune scéance à venir</p>
		@endif
		

		@endforeach
	</ul>
</p>
@endif

@if($cours->eleve->count())
<p>
	{{('Liste des scéances')}}
	<ul>
		@foreach($cours->sceance as $sceance)
		
		

		<li>{{link_to_route('voirSceances',BaseController::dateEu($sceance->date),$sceance->id)}}</li>

		@endforeach
	</ul>
</p>
@endif

@endif
@stop