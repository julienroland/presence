@extends('layout.layout')

@section('container')
<div class="breadcrumbs">
	{{HTML::link('/','accueil')}} > <span>Gerer mes groupes</span>
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

@if($groupes->count())
{{link_to_route('creerGroupes','Créer un nouveau groupe')}}
<table class="coursTable">
	<thead>
		<tr>
			<th>Nom</th>
			<th>Option</th>
			<th>Année</th>
			<th>modifier / supprimer</th>
		</tr>


		@foreach($groupes as $groupe)

		<tr class="impair">
			
			<td>{{link_to_route('voirGroupes',$groupe->nom,$groupe->slug)}}</td>
			<td>{{$groupe->option->nom}}</td>
			<td><ul>@foreach($groupe->anneeLevel as $anneeLevel)<li>{{$anneeLevel->nom}}</li>@endforeach</ul></td>
			<td>{{link_to_route('editerGroupes','Modifier',array($groupe->slug))}}
				/ {{link_to_route('supprimerGroupes','Supprimer',array($groupe->slug))}}</td>

			</tr>

			@endforeach
		</tbody>
	</table>
	@else
	<p>
		{{('Vous n\'avez aucun groupe, en ajouter maintenant' )}}
		{{link_to_route('creerGroupes','Créer un nouveau groupe')}}
	</p>
	@endif
	@stop