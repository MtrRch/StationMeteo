<!DOCTYPE html>
  <html>
    <head>
      
	    <title>Weather 'Math' Station</title>
		<link rel="icon" type="image/png" href="icones/favicon_cloud.png" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		<meta http-equiv="Content-Language" content="Fr"/>
		<meta name="Author" lang="fr" content="Mathieu"/>
		<meta name="Copyright" content="© Mathieu"/>
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0">
		<meta http-equiv="refresh" content="3600;url=index.php">
		<!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	  
	  <script src="js/jquery.js"></script>
	  
    </head>
	
	<body>

	<nav class="nav-extended green">
		<div class="nav-wrapper">
		  <a href="#" class="brand-logo">Weather Station</a>
		  <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
		  <ul id="nav-mobile" class="right hide-on-med-and-down">
			<li><a href="index.php">Station Météo</a></li>
			<li><a href="Info_syst.php">Informations Système</a></li>
		  </ul>
		</div>
	</nav>

	<ul class="sidenav" id="mobile-demo">
		<ul class="collection">
			<li class="collection-item avatar">
				<img src="icones/Green_Cloud.png" alt="" class="circle">
				<span class="title green-text text-darken-2"><b>Weather 'Math' Station</b></span>
				<p class="green-text text-darken-2">By Mamath
				</p>
			</li>
		</ul>
		<li><a href="index.php"class="title green-text text-darken-2">Station Météo</a></li>
		<li><a href="Info_syst.php"class="title green-text text-darken-2">Informations Système</a></li>
	</ul>
	
	<div class="col s12 m12 l12"></div>
	
	<div class="row ">
		<div class="col s1 m1 l1"></div>
		
		<div class="col s10 m10 l10"> <!--titre-->
			<h1 class="green-text text-darken-2 center-align "> <b>Version</b></h1>		  
		</div>
		
		<div class="col s1 m1 l1"></div>

	</div>	
	
	<div class="row ">
		<div class="col s1 m1 l1"></div>
		<div class="col s10 m10 l10">   <!--en-tête-->
			<h5 class="green-text text-darken-2 center-align"> <b>Weather Station By Mamath</b></h5> <br />
				
			<div class="divider"></div>
		</div>
		<div class="col s1 m1 l1"></div>
	</div>
	
	<br />
	
	<div class="row ">
		<div class="col s1 m1 l1"></div>
		
		<div class="col s10 m10 l10">
			<ul class="green collapsible popout"> <!--menu déroulant-->
				<li>
				  <div class="collapsible-header"><i class="material-icons">filter_drama</i><b>Versions</b></div> <!--titre du menu-->
				  <div class="collapsible-body"> <!--corp du menu-->
					<span><b>Version 1.0:</b></span><br /><br />
					<span><b>Creation de l'interface web "responsive"</b></span><br />
					<span> Onglet "station météo": interface principale</span><br />
					<span> Onglet "Informations Système": donnant des informations sur l'état du système (RPI)</span><br />
					<span> Onglet "Version": Version de la station météo + informations diverses</span><br />
					<span><b>Reception de l'etat des capteurs "chambre" et "Salon", prédispo capteur "ext"</b></span><br />
					<span><b>Réception des données des capteurs distants 433MHz </b></span><br />
					<span><b>Ecriture ddu fichier "*.csv"</b></span><br />
					<span><b>Tracer des courbes dans des fichier "*.png" </b></span><br />

				  </div>
				</li>
				<li>
				  <div class="collapsible-header"><i class="material-icons">filter_drama</i><b>Hardware</b></div> <!--titre du menu-->
				  <div class="collapsible-body"> <!--corp du menu-->
						<span> - Raspberry pi version 3</span><br />
						<span> - dongle Wi-fi "Wi-Pi"</span><br />
						<span> - Passerelle 433MHz "RFLink"</span><br />
						<span> - 2 Capteurs Daniu 433MHz  (température et humidité) Pour Salon et chambre</span><br />
						<span> - prédisposition Capteur Orégon THGR810 (température et humidité) pour ext</span><br />
				  </div>
				</li>
				<li>
				  <div class="collapsible-header"><i class="material-icons">filter_drama</i><b>Software</b></div> <!--titre du menu-->
				  <div class="collapsible-body"> <!--corp du menu-->
					<span><b> - Système d'exploitation (OS)</b></span><br />
					<span>      Raspbian "November 2018"</span><br />
					<span><b> - Interface Web</b></span><br />
					<span>      Serveur Appache "2"</span><br />
					<span>      PhP "7"</span><br />
					<span>      Materialize "1.0.0"</span><br />
					<span><b> - Acquisition des Données radio (433MHz)</b></span><br />
					<span>      Domoticz "4.9700" du 23/06/2018</span><br />
				  </div>
				</li>
			</ul>
		</div>
		<div class="col s1 m1 l1"></div>
	</div>
		
	<div class="col s12 m12 l12"> <!--lien vers le projet github "target" permet d'ouvrir un nouvel onglet-->
		<h6 class="green-text text-darken-2 center-align " > <a href="https://github.com/MtrRch/StationMeteo" target="_blank">Projet GitHub </a> </h6>
	</div>
	
	
	
	
	
	
	
	
	
	
	
	</body>
	

	
	
	<script type="text/javascript">
	// paragraphe déroulant
	$(document).ready(function(){
		$('.collapsible').collapsible();
	});
	</script>
	
	
	 <script type="text/javascript">
	 // Script outon flottant
	$(document).ready(function()
	{
		$('.fixed-action-btn').floatingActionButton();
	});
	</script>
	
	<script type="text/javascript">
	// Script pour le 'sidenav'
	$(document).ready(function()
	{
		$('.sidenav').sidenav();
	});
    </script>
	
	<script type="text/javascript">
	// Script pour les sélecteur de graph
	$(document).ready(function()
	{
		$('select').formSelect();
	});
	</script>
	
    <script type="text/javascript" src="js/materialize.js"></script>
  </html