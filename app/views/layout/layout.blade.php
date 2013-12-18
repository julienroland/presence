<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
  {{HTML::style('css/screen.css')}}

  {{HTML::script('js/vendor/modernizr-2.6.2.min.js')}}
</head>
<body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->

            <h1 class="section" role="heading" aria-level="1">Bienvenue sur le site de gestion de présences de la Haute Ecole de La Province de Liège</h1>
            <section class="container">
              <h1 class="section" role="heading" aria-level="1">Contenu principal de la page</h1>

              <section class="banner">
                <h1 class="section" role="heading" aria-level="1">Bannière du site</h1>
                <div class="wrapper">
                  <div class="logo">
                    @if(Auth::check())
                     <h3 role="heading" aria-level="3">{{link_to('/',Session::get('user')['prenom'].' '.Session::get('user')['nom'])}}</h3>
  
                    @else
                    <h3 role="heading" aria-level="3"><abbr title="Haute Ecole de La Province de liège">{{link_to('/','HEPL')}}</abbr></h3>
                    <span class="underTitle">Les présences</span>
                    @endif
                  </div>
                  <nav class="nav" id="nav" role="navigation">
                    <a href="#main" class="reader">Passer directement au contenu</a>
                    <h1 class="section" role="heading" aria-level="1">Navigation de la page</h1>
                   
                      @if(Auth::check() && Session::has('user'))
                      <div>{{HTML::link('deconnecter','déconnecter',array('class'=>'btn'))}}</div>
                      @else

                      <div>{{HTML::link('inscription','incription',array('class'=>'btn'))}}</div>
                      @endif

                    </ul>
                  </nav>
                </div>
              </section>
              <section class="main wrapper" id="main">
               <h1 class="section" role="heading" aria-level="1">Contenu principal de la page</h1>
               
                 @yield('container')
               
             </section>
             <footer class="foot" role="contentinfo">
               <h1 class="section" role="heading" aria-level="1">Informations additionelles à la page</h1>
               <div class="wrapper">
                 <a href="#main" class="reader">Remonter au contenu</a>
                 <a href="#nav" class="reader">Revenir à la navigation</a>

                 <span class="copyright">Crée par Julien Roland - 2013</span>
               </div>
             </footer>
           </section>

           {{HTML::script('js/jquery-ck.js')}} 
           {{HTML::script('js/main.js')}}
    
        </body>
        </html>
