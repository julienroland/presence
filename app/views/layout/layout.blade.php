
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
    <title>Présence | @yield('title','Présence | accueil')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    {{HTML::style('css/screen.css')}}
    {{HTML::script('js/vendor/modernizr-2.6.2.min.js')}}

  </head>
  <body>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
    <![endif]-->
    <h1 class="section" role="heading" aria-level="1">@yield("head","Page d'accueil de l'application présence")</h1>
    <section class="container ">
      <h1 class="section" role="heading" aria-level="1">Contenu de la page</h1>
      <section class="banner" role="banner">
        <div class="logo">
          <h1 role="heading" aria-level="1"><span class="prenom">{{Auth::user()->prenom}}</span> <span class="nom">{{Auth::user()->nom}}</span>
          </h1>
        </div>

        <div class="deco">
          @if(Auth::check() && Session::has('user'))
          {{HTML::link('deconnecter','déconnecter')}}
          @endif
        </div>
        <nav role="navigation" class="nav">
          <div class="wrapper">
            <h1 class="section">Navigation principal du site</h1>
            <a href="#main" class="reader">Passer au contenu directement</a>
            {{link_to('index','HEPL',array('class'=>'accueil'))}}
            <a class="menuLow" href="#menu"><span>Menu</span></a>
            <ul class="menu" id="menu">
              <li>{{link_to('cours','Mes cours')}}</li>
              <li>{{link_to('sceances','Mes scéances')}}</li>
              <li>{{link_to('eleves','Mes élèves')}}</li>
              <li>{{link_to('groupes','Mes groupe')}}</li>
              <li><a href="config.php">Configuration</a></li>
            </ul>
          </div>
        </nav>
      </section>
   

       @yield('container')


     <footer role="footer" class="foot">
      <div class="wrapper">
        <span class="copyright">Site crée pour La Haute Ecole de La Province de Liège par <a
          href="http://julien-roland.be">Julien&nbsp;Roland</a> en 2013 - 2014</span>
        </div>
      </footer>


      {{HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js')}}
      {{HTML::script('js/main.js')}}

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
