<!DOCTYPE html>
<!--[if lt IE 7]>
	<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
	<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
	<html class="no-js lt-ie9"> <![endif]-->
	<!--[if gt IE 8]><!-->
	<html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

		<link rel="stylesheet" href="css/screen.css">
		<script src="js/vendor/modernizr-2.6.2.min.js"></script>
	</head>
	<body>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
    <![endif]-->
    <h1 class="section" role="heading" aria-level="1">Page d'accueil du site présence de la Haute Ecole de La Province </h1>
    <section class="container ">
    	<h1 class="section" role="heading" aria-level="1">Contenu de la page</h1>

    	<section role="main" class="main wrapper one" id="main">
    		<h1 class="section">Contenu principal du site</h1>
    		<div class="logo">
    			<h1><a href=""><abbr title="Haute Ecole de La Province de Liège">HEPL</abbr></a></h1>
    		</div>
    		<div class="intro">
    			<p>
    				Plateforme de gestion de présence pour les professeurs de la Haute Ecole de La Province de Liège.
    			</p>
    		</div>
    		<div class="connexion">
    			{{Form::open(array('url'=>'identifier','id'=>'connexion'))}}
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

    			{{form::label('email','Votre e-mail')}}
    			{{Form::email('email','',array('placeholder'=>'prenom.nom@hepl.be','required'))}}

    			{{form::label('password','Votre mot de passe')}}
    			{{Form::password('password',array('required'))}}


    			{{form::submit('Connexion')}}

    			<div class="problemeCompte">
    				<a href="">Mot de passe oublié ?</a>
    				<span>/</span>
    				<a href="">Pas encore inscrit ?</a>

    			</div>

    		</form>
    	</div>
    </section>

</section>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
<script src="js/main.js"></script>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
	(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
	e=o.createElement(i);r=o.getElementsByTagName(i)[0];
	e.src='//www.google-analytics.com/analytics.js';
	r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
	ga('create','UA-XXXXX-X');ga('send','pageview');
</script>
</body>
</html>




