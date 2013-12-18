@extends('layout.layout')

@section('container')
<div class="breadcrumbs">
	{{HTML::link('/','accueil')}} > <span>Gerer mes cours</span>
</div>
@if(Session::has('error'))
<div class="error">
	{{Session::get('error')}}
</div>
@endif
@if(Session::has('success'))
<div class="success">
	{{Session::get('success')}}
</div>
@endif



<p>{{('Liste de mes cours')}}</p>

@if($cours->count())

{{(link_to_route('creerCours','Créer un nouveau cours'))}}

<table class="coursTable">
	<thead>
		<tr>
			<th>intitulé</th>
			<th>Année</th>
			<th>Durée</th>
			<th>Option</th>
			<th>Groupe</th>
			<th>Modifier / supprimer</th>
		</tr>
	</thead>
	<tbody>

		@foreach($cours as $cours)

		<tr class="impair">
			<td>{{link_to_route('voirCours',$cours->nom,array($cours->slug))}}</td>
			<td>{{$cours->anneeLevel_id}}e année</td>
			<td>{{$cours->duree}} heures</td>
			
			<td>
				@foreach($cours->option as $option)
				
					@if(isset($option->id))
					<ul>
						 <li>{{$option->nom}}</li>
					</ul>
					@endif
				@endforeach
			</td>
			<td>
				
				@foreach($cours->groupe as $groupe)
					
					@if(isset($groupe->id))
					<ul>
						<li>{{$groupe->nom}}<li>
					</ul>

					@endif
				@endforeach
				
			</td>
			<td>{{link_to_route('editerCours','modifier',array($cours->slug)) }} / {{link_to_route('supprimerCours','supprimer',array($cours->slug)) }}</td>

		</tr>
		@endforeach
	</tbody>
</table>
@else
{{('Vous n\'avez aucun cours, en ajouter maintenant' )}} {{(link_to_route('creerCours','Créer un nouveau cours'))}}

@endif
@stop