@extends('layout.layout')

@section('container')

@if(Auth::check())
<div class="breadcrumbs">
	<span>Accueil</span>
</div>
<div class="infoSide">
</div>
<div class="mainSide">
<ul class="secondaryMenu">
	<li>{{link_to('gererMesCours','Gérer mes cours',array('class'=>'btn'))}}</li>
	<li>{{link_to('gererMesSceances','Gérer mes scéances',array('class'=>'btn'))}}</li>
	<li>{{link_to('gererMesEleves','Gérer mes élèves',array('class'=>'btn'))}}</li>
	<li>{{link_to('gererMesGroupes','Gérer mes groupes',array('class'=>'btn'))}}</li>
	<li><a href="" class="btn">Configuration</a></li>
</ul>
</div>
@else
<section class="connexion">
	<div class="headerBox">
		<h3>Connexion</h3>
	</div>

	{{Form::open(array('url'=>'identifier','id'=>'connexion','class'=>'wrapper'))}}

	@if ($errors->any())
	<div class="errors">
		<ul>
			{{ implode('', $errors->all('<li class="error">:message</li>')) }}
		</ul>
	</div>
	@endif

	@if(Session::has('success'))
	<div class="success">
		{{Session::get('success')}}
	</div>
	@endif

	@if(Session::has('error'))
	<div class="errors">
		{{Session::get('error')}}
	</div>
	@endif
	@if(isset($expiration))
	<div class="informations">
		{{$expiration}}
	</div>
	@endif


	{{Form::label('email','Votre e-mail')}}
	{{Form::email('email','',array('placeholder'=>'Entrez votre e-mail'))}}

	{{Form::label('mdp','Votre mot de passe')}}
	{{Form::password('mdp','')}}

	{{Form::submit('Connecter')}}
	<span class="helperAccount"><a href="">Mot de passe oublié ?</a> / {{link_to_route('inscription','S\'inscrire')}}</span>
	{{ Form::close() }}
</section>
@endif
</div>

@stop