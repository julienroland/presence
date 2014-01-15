@extends('layout.layout')

@section('title', strip_tags($title))
@section('head', strip_tags($head))

@section('container')
<section role="main" class="main accueil" id="main">
    <h1 class="section">Contenu principal du site</h1>

    <div class="breadcrumbs">
        <div class="wrapper">
            <span>Accueil</span>
        </div>
    </div>
    <div class="news">
        <div class="wrapper">
            <section class="sceanceEnCours">
                <h2 role="heading" aria-level="2" class="titleIndex">Scéance en cours</h2>
                <hr/>
                <div class="sceance">
                    <div class="titre">
                        <h3 role="heading" aria-level="3">{{$sceance->coursNom}}</h3>
                    </div>
                    <div class="number">
                        <span>{{$presence ? $presence : 0}}</span>
                    </div>
                    <span class="text">{{('présent(s)')}}</span>

                    <div class="overImage">

                        {{link_to_route('voirSceances','Voir',$sceance->sceancesId,array('class'=>'btn','title'=>'Voir la scéance'))}}
                    </div>
                </div>

            </section>

            <section class="mesCours">
                <h2 role="heading" aria-level="2" class="titleIndex">Mes cours</h2>
                <hr/>
                @foreach($cours as $oneCours)

                <div class="cours">
                    <div class="titre">
                        <h3 role="heading" aria-level="3">{{ucfirst($oneCours->nom)}}</h3>
                    </div>
                    <div class="horaire">
                        <span class="debut">{{$oneCours->duree}}</span>
                        <span class="fin">{{$oneCours->anneeLevel_id}}<sup>{{('e')}}</sup></span>
                    </div>
                    <div class="overImage">

                        {{link_to_route('voirCours','Voir',$oneCours->slug,array('class'=>'btn','title'=>'Voir le cours'))}}
                    </div>
                </div>
                @endforeach

            </section>
        </div>
    </div>
    <div class=" calendrier">
        <div class="wrapper">
            <section class="planning">
                <h2 class="titleIndex" role="heading" aria-level="2">Planning</h2>
                <hr/>


                <?php
                $dateComponents = getdate();
                $year = $dateComponents['year'];
                
                $i = 1;
                $month=1; //Numeric Value
                while($i <= 12){?>
                {{Helpers::build_calendar($month,$year,$dateComponents)}}
                <?php $month=$month+1;
                $i++;}
                ?>

            </section>
        </div>
    </div>
    <div class="popupCreerThis">
        <div class="close"><a href="" title="Fermer la fenêtre"><span>Fermer</span></a></div>
        <h3 aria-level="3" role="heading" class="indexTitle">Crée une nouvelle scéance</h3>
        <hr/>
        {{Form::open(array('method'=>'get'))}}

        {{Form::label('cours','Quel cours')}}
        {{Form::select('cours',$listCours,'')}}

        <div class="leftForm">

            {{Form::label('start','Heure du début')}}
            {{Form::text('start','8:20',array('required'))}}
            {{Form::label('end','Heure de fin')}}
            {{Form::text('end','17:40',array('required'))}}

        </div>
        <div class="rightForm">

            {{Form::label('repetition','Tous les')}}
            {{Form::select('repetition',array('1','2','3','4','5','6','7','8'),'')}}<span>semaine(s)</span>

            {{Form::label('temps','Pendant')}}
            {{Form::select('temps',array('1','2','3','4','5','6','7','8','9','10','11','12','13','14'),'')}}<span>semaine(s)</span>
        </div>
        {{Form::hidden('date','',array('class'=>'date'))}}
        {{Form::hidden('jour','',array('class'=>'jour'))}}
        {{Form::submit('Créer',array('class'=>'btn'))}}

        {{Form::close()}}
    </div>  
    <div class="popupModifierThis">
        <div class="close"><a href="" title="Fermer la fenêtre"><span>Fermer</span></a></div>
        <h3 aria-level="3" role="heading" class="indexTitle">Modifier une scéance</h3>
        <hr/>
        {{Form::open(array('method'=>'get'))}}

        {{Form::label('cours','Pour quel cours')}}
        {{Form::select('cours',$listCours)}}

        {{Form::label('jour','Pour quel jour')}}
        {{Form::select('jour',$listDay)}}

        {{Form::label('debut','Heure du début')}}
        {{Form::text('debut','',array('placeholder'=>'Format: 5:32'))}}

        {{Form::label('fin','Heure de fin')}}
        {{Form::text('fin','',array('placeholder'=>'Format: 16:30'))}}

        {{Form::hidden('sceance','',array('class'=>'sceance'))}}
        {{Form::submit('Modifier',array('class'=>'btn'))}}
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
<div class="actions">
   <span><a class="voir" title="Aller sur la fiche de la scéance" href="voirSceance.php">Voir</a></span>
   <span><a class="modifier" title="Modifier la scéance" href="">Modifier</a></span>
   <span><a class="supprimer" title="Supprimer la scéance" href="">Supprimer</a></span>
   <a href="" title="Supprimer ce cours" class="btn delete">Supprimer</a>
</div>
<div class="actionsPlanning">
 <span><a class="creer" title="Créer une scéance" href="">Créer</a></span>
 <a href="" title="Supprimer ce cours" class="btn delete">Supprimer</a>
</div>
<div class="overlay">

</div>
</div>
</section>

</section>
@stop