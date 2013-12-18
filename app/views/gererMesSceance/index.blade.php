@extends('layout.layout')

@section('container')
<div class="breadcrumbs">
	{{HTML::link('/','accueil')}} > {{('Gerer mes scéances')}}
</div>
	@if ($errors->any())
	<div class="errors">
		<ul>
			{{ implode('', $errors->all('<li class="error">:message</li>')) }}
		</ul>
	</div>
	@endif
	@if(Session::has('erorr'))
	<div class="error">
		{{Session::get('error')}}
	</div>
	@endif
	@if(Session::has('success'))
	<div class="success">
		{{Session::get('success')}}
	</div>
	@endif
	
	
	@if(isset($sceances) && !empty($sceances))
	{{link_to_route('creerSceances','créer une nouvelle scéance')}}
	<table class="coursTable">
		<thead>
			<tr>
				<th>Cours</th>
				<th>Année</th>
				<th>Groupe</th>
				<th>Durée</th>
				<th>Commence</th>
				<th>Fini</th>
				<th>A la date du</th>
				<th>Jour</th>
				<th>modifier / supprimer</th>
			</tr>
	
			
			@foreach($sceances as $sceance)
			<tr class="impair">
		
				<td>{{link_to_route('voirSceances',$sceance->coursNom,$sceance->sceancesId)}}</td>
				<td>{{$sceance->anneeLevel}}</td>
				<td>{{$sceance->groupe}}</td>
				<td>{{$sceance->duree}} {{('heure(s)')}}</td>
				<td>{{$sceance->debut}} {{('heures')}}</td>
				<td>{{$sceance->fin}} {{('heures')}}</td>
				<td>
				<?php $dateExplode = explode('-',$sceance->date);
				$dateEu = $dateExplode[2].'/'.$dateExplode[1].'/'.$dateExplode[0];
				 ?>
				{{$dateEu}}
				</td>
				<td>{{$sceance->dayNom}}</td>
				<td>{{link_to_route('editerSceances','Modifier',array($sceance->sceancesId))}}
					/ {{link_to_route('supprimerSceances','Supprimer',array($sceance->sceancesId))}}</td>

			</tr>

				@endforeach
			</tbody>
		</table>
		@else
		<p>
		{{('Vous n\'avez aucune scéance, en ajouter maintenant' )}} {{link_to_route('creerSceances','créer une nouvelle scéance')}}
		</p>
		@endif
	

	@stop