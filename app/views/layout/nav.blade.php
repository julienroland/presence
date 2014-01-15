  @extends('layout')
  @section('nav')
  <nav role="navigation" class="nav">
          <div class="wrapper">
            <h1 class="section">Navigation principal du site</h1>
            <a href="#main" class="reader">Passer au contenu directement</a>
            <a class="accueil" href="index.php">HEPL</a>
            <a class="menuLow" href="#menu"><span>Menu</span></a>
            <ul class="menu" id="menu">
              <li><a href="cours.php">Mes cours</a></li>
              <li><a href="sceances.php">Mes scéances</a></li>
              <li><a href="eleves.php">Elèves</a></li>
              <li><a href="groupes.php">Mes groupes</a></li>
              <li><a href="config.php">Configuration</a></li>
            </ul>
          </div>
        </nav>
        @stop