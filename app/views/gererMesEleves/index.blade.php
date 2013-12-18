@extends('layout.layout')

@section('container')
<div class="breadcrumbs">
	{{HTML::link('/','accueil')}} > <span>Gerer mes élèves</span>
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

@if(isset($eleves) && !empty($eleves))
{{link_to_route('creerEleves','ajouter un nouvel élève ')}}
<table class="coursTable">
	<thead>
		<tr>
			<th>Prénom & nom</th>
			<th>Année</th>
			<th>email</th>
			<th>Option</th>
			<th>Photo</th>
			<th>modifier / supprimer</th>
		</tr>


		@foreach($eleves as $eleve)

		<tr class="impair">
			
			<td>{{link_to_route('voirEleves',$eleve->prenomEleve.' '.$eleve->nomEleve,$eleve->slug)}}</td>
			<td>{{$eleve->anneeLevel}}<sup>e</sup> année</td>
			<td>{{$eleve->email}}</td>
			<td>{{$eleve->option}}</td>
			<td><img src='{{$eleve->photo}}'/></td>
			<td>{{link_to_route('editerEleves','Modifier',array($eleve->slug))}}
				/ {{link_to_route('supprimerEleves','Supprimer',array($eleve->slug))}}</td>

			</tr>

			@endforeach
		</tbody>
	</table>
	@else
	<p>
		{{('Vous n\'avez aucun élève, en ajouter maintenant' )}} {{link_to_route('creerEleves','ajouter un nouvel élève ')}} 
	</p>
	@endif
	@stop