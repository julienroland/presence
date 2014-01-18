@extends('layout.layout')

@section('title', strip_tags($title))
@section('head', strip_tags($head))

@section('container')
<section role="main" class="main" id="main">
	<h1 class="section">Contenu principal du site</h1>

	<div class="breadcrumbs">
		<div class="wrapper">
			{{link_to('index','Accueil')}}&nbsp;/&nbsp;<span>Mes cours</span>
		</div>
	</div>
	<div class="wrapper actionsSmall">
		<a href="creerCours.php" class="btn">Créer un cours</a>
	</div>

	<div class="wrapper">
		<section class="gererMesCours">
			<h2 role="heading" aria-level="2" class="titleIndex">Mes cours</h2>
			<hr/>
			@foreach($cours as $cours)

			<div class="cours">
				<div class="groupe">
					@foreach($cours->groupe as $groupe)
					{{$groupe->nom}}
					@endforeach
				</div>
				<div class="titre">
					<h3 role="heading" aria-level="3">{{$cours->nom}}</h3>
					<span class="option">
						@foreach($cours->option as $option)
						{{$option->nom}}
						@endforeach
					</span>
				</div>


				<div class="horaire">
					<span class="debut">{{$cours->duree}}</span>
					<span class="fin">{{$cours->anneeLevel_id}}<sup>e</sup></span>
				</div>
				<div class="overImage">

					{{link_to_route('voirCours','Voir',$cours->slug,array('class'=>'btn','title'=>'Voir le cours'))}}
					<a href="" class="btn" title="Modifier ce cours">Modifier</a>
					<a href="" title="Supprimer ce cours" class="btn delete">Supprimer</a>

				</div>
			</div>  
			@endforeach

			<div class="popupCreer">
				<div class="close"><a href="" title="Fermer la fenêtre"><span>Fermer</span></a></div>
				<h3 aria-level="3" role="heading" class="indexTitle">Crée un nouveau cours</h3>
				<hr/>
				<form action="">
					<div class="leftForm">
						<label for="intitule">Intitulé</label>
						<input type="text" name="intitule" id="intitule" placeholder="Math">

						<label for="duree">Durée (heure(s))</label>
						<select name="duree" id="duree">
							<option value="1">1</option>
						</select>

						<label for="anneeLevel">Année d'étude</label>
						<select name="anneeLevel" id="anneeLevel">
							<option value="1">1e inforgraphie</option>
						</select> 
					</div>
					<div class="rightForm">
						<label for="option">Option</label>
						<select multiple="1" name="option[]" id="option">
							<option value="1">Web</option>
						</select>

						<label for="groupe">Groupe</label>
						<select multiple="1" name="groupe[]" id="groupe">
							<option value="1">2283</option>
						</select>
					</div>
					<input type="submit" value="Créer" class="btn">
				</form>
			</div>  
			<div class="popupModifier">
				<div class="close"><a href="" title="Fermer la fenêtre"><span>Fermer</span></a></div>
				<h3 aria-level="3" role="heading" class="indexTitle">Modifier un cours</h3>
				<hr/>
				<form action="">
					<label for="cours">Quel cours ?</label>
					<select name="cours" id="cours">
						<option value="1">Web</option>
					</select>
					<div class="leftForm">
						<label for="intitule">Intitulé</label>
						<input type="text" name="intitule" id="intitule" placeholder="Math">

						<label for="duree">Durée (heure(s))</label>
						<select name="duree" id="duree">
							<option value="1">1</option>
						</select>

						<label for="anneeLevel">Année d'étude</label>
						<select name="anneeLevel" id="anneeLevel">
							<option value="1">1e inforgraphie</option>
						</select> 
					</div>
					<div class="rightForm">
						<label for="option">Option</label>
						<select multiple="1" name="option[]" id="option">
							<option value="1">Web</option>
						</select>

						<label for="groupe">Groupe</label>
						<select multiple="1" name="groupe[]" id="groupe">
							<option value="1">2283</option>
						</select>
					</div>
					<input type="submit" value="Modifier" class="btn">
				</form>
			</div>
			<div class="popupSupprimer">
				<div class="close"><a href="" title="Fermer la fenêtre"><span>Fermer</span></a></div>
				<h3 aria-level="3" role="heading" class="indexTitle">Supprimer un cours</h3>
				<hr/>
				<form action="">
					<label for="cours">Quel cours ?</label>
					<select name="cours" id="cours">
						<option value="1">Web</option>
					</select>

					<input type="submit" value="Supprimer" class="btn">
				</form>
			</div>
			<div class="popupVoir">
				<div class="close"><a href="" title="Fermer la fenêtre"><span>Fermer</span></a></div>
				<h3 aria-level="3" role="heading" class="indexTitle">Voir un cours</h3>
				<hr/>
				<form action="">
					<label for="cours">Lequel ?</label>
					<select name="cours" id="cours">
						<option value="1">Web</option>
					</select>

					<input type="submit" value="Voir" class="btn">
				</form>
			</div>
		</section>
		<aside class="helper">
			<h1 aria-level="1" class="section">Intéraction avec les cours</h1>
			<ul>
				<li><a data-link="creer" href="" title="Créer un nouveau cours">Créer un cours</a></li>
				<li><a data-link="modifier" href="" title="Modifier un cours">Modifier un cours</a></li>
				<li><a data-link="supprimer" href="" title="Supprimer un cours">Supprimer un cours</a></li>
				<li><a data-link="voir" href="" title="Voir un cours">Voir un cours</a></li>
			</ul>
		</aside>
	</div>
	<div class="wrapper">
		<section class="presenceTotalCours">
			<h2 role="heading" aria-level="2" class="titleIndex">Taux de présence à vos cours</h2>
			<hr/>
			
			<div class="pourcentagePresenceTotalCours">
				<span>{{$percentTotal}}</span>
			</div>
			<div class="graphPresenceTotalCours">
				<ul class="dataGraph" data-total="60">
					@foreach($percentByCours as $cours)
					<li data-percent="{{$cours['percent']}}" data-cours="{{$cours['nom']}}">{{$cours['nom']}}</li>
					@endforeach

				</ul>
				<canvas id="graphPresenceTotalCours" width="600" height="300">
				</div>

			</section>
			<div class="helper">

			</div>
		</div> 
		<div class="wrapper">
			<section class="presenceParCours">
				<h2 role="heading" aria-level="2" class="titleIndex">Taux de présence par cours</h2>
				<hr/>
				@foreach($percentByCours as $cours)
				<div class="pourcentagePresenceParCours">
					<span class="nom">{{link_to_route('voirCours',$cours['nom'],$cours['slug'],array('title'=>'Voir le cours'))}}</span>
					<span class="percent">{{$cours['percent']}}%</span>
				</div>
				@endforeach
				


			</section>
			<div class="helper">

			</div>
		</div>
		<div class="overlay">

		</div>

	</section>

</section>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script src="js/graphTotalCours-ck.js"></script>

@stop