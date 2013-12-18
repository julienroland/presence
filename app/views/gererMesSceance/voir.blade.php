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
	{{HTML::link('/','accueil')}} > {{HTML::link('gererMesSceances','Gerer mes sceance')}} > <span>{{('Voir la sceance du')}} {{$dateWellFormated}}</span>
</div>
<div class="mainSide">
	<div class="wrapper">
		@if($sceance->count())

		<p>
			{{('Cours de')}} {{$sceance->cours->nom}}

			{{('pour le')}} {{$sceance->day->nom}} 

			{{('pendant')}} {{$sceance->cours->duree}} {{('heures ')}}
			{{('commençant à')}} {{$sceance->date_start}} {{('et finissant à')}} {{$sceance->date_end}}
		</p>

		<ul>

			<h3>Prendre les présences </h3>

			@foreach($presences as $presence)					
			
			@if($presence->presenceId == 0)

			<li class="presence notDone">
				@elseif($presence->presenceId == 3)
				<li class="presence ok">
					@else
					<li class="presence notOk">
						@endif

						<span class="eleve {{$presence->eleveId}}">{{link_to_route('voirEleves',$presence->prenom.' '.$presence->nom,array($presence->eleveSlug))}}</span>

						<ul class="presenceChoice">
							@foreach($listPresence as $presences)
							<li><a href="" data-idpresence="{{$presences->id}}" data-ideleve="{{$presence->eleveId}}" data-idsceance="{{$presence->sceanceId}}">{{$presences->type}}</a></li>
							@endforeach

						</ul>
						<div class="image">
							<img src="{{$presence->photo}}" />
						</div>

					</li>

					@endforeach
				</ul>
			</div>
			<div class="wrapper">
				<h3 id="sceanceData" data-groupe={{$listGroupeIdJson}}>{{$pourcentagePresence}} de présence</h3>
			</div>
			<div class="wrapper">
				<h3 id="groupeData" data-groupe={{$listGroupeJson}}>Pourcentage de présence par groupe</h3>
				<ul>
					@foreach($presenceGroupe as $groupePresence)
					
					<li class="groupePresence" data-groupeId={{$groupePresence->id}}>
						<div class="nom">{{$groupePresence->nom}}</div>
						<div class="percent"> {{$groupePresence->percent}}</div>
					</li>

					@endforeach
				</ul>
			</div>

		</div>
		
		<div class="infoSide">
			<ul>
				@foreach($sceance->cours->groupe as $groupe)

				<li>{{$groupe->nom}}</li>

				@endforeach
			</ul>
			<ul>
				<li>{{link_to_route('creerSceances','Créer une scéance')}}</li>
				<li>{{link_to_route('editerSceances','Modifier la scéance',$sceance->id)}}</li>
				<li>{{link_to_route('supprimerSceances','Supprimer la scéance',$sceance->id)}}</li>
			</ul>
		</div>
		@endif

		@stop