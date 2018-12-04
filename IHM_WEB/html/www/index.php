<!DOCTYPE html>
  <html>
    <head>
      
	    <title>Weather Station</title>
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
	
	<?php 
		// Execute un refresh de la page en PHP

		$delai=60;  // délai en secondes
		header("Refresh: $delai;");
	?>
	
	<?php //Relecture de la dernière ligne du CSV + inscription dans les variables
			$ligne = 1; // compteur de ligne
			$fic = fopen("export_donnees_SenseHat.csv", "r"); //Ouverture du fichier en lecture
			while($tab=fgetcsv($fic,0,'|'))
			{
				$champs = count($tab);//nombre de champ dans la ligne en question
				//echo " Les " . $champs . " champs de la ligne " . $ligne . " sont :";
				$ligne ++;
				//affichage de chaque champ de la ligne en question
				 for($i=0; $i<$champs; $i ++)
				 {
					//echo $tab[$i] . "";
				 }
				$CSV_date = $tab[0];
				$CSV_heure = $tab[1];
				$temp1 = $tab[2];
				$temp2 = $tab[3];
				$hum= $tab[4];
				$pression = $tab[5];
				$Temp_ext= $tab[6];
				$Hum_ext= $tab[7];
				$Temp_chambre= $tab[8];
				$Hum_chambre= $tab[9];
			}
	?>
	
	<?php
		setlocale(LC_TIME, 'fr_FR.utf8','fra'); //useles sur la rasp OK sur win
		$date = strftime('%A %d %B %Y');
		$heure = strftime('%H:%M');
	?>
	
	<?php
		$Sunset = date_sunset(time(),SUNFUNCS_RET_STRING,48.77,2.07,90,1);
		$Sunrise = date_sunrise(time(),SUNFUNCS_RET_STRING,48.77,2.07,90,1);
	?>
	
	<?php
		// Informations mémoire
		 $Esp_libre = disk_free_space("/");
		 $Esp_total = disk_total_space("/");
		 //$Esp_csv = filesize("/var/www/html/export_donnees_SenseHat.csv");
		 $Esp_csv = filesize("export_donnees_SenseHat.csv");
		 
		 $SI_prefix = array('o', 'Ko', 'Mo', 'Go', 'To');
		 
		 $index = 0; // définition unité + division de l'espace mesuré
		 while ( $Esp_libre >=1024)
		 {
			 $Esp_libre/=1024;
			 $index++;
		 } 
		 $Esp_libre_unit = $SI_prefix[$index];
		 
		 $index = 0; // définition unité + division de l'espace mesuré
		 while ( $Esp_total >=1024)
		 {
			 $Esp_total/=1024;
			 $index++;
		 } 
		 $Esp_total_unit = $SI_prefix[$index];
		 
		 $index = 0;// définition unité + division de l'espace mesuré
		 while ( $Esp_csv >=1024)
		 {
			 $Esp_csv/=1024;
			 $index++;
		 } 
		 $Esp_csv_unit = $SI_prefix[$index];
		 
		$Esp_libre = round($Esp_libre, 2);
		$Esp_total = round($Esp_total, 2);
		$Esp_csv = round($Esp_csv,2);

	?>
	
	<body>

	<nav class="nav-extended blue"> <!--zone au dessus des onglets-->
		<div class="nav-wrapper">
		  <a href="#" class="brand-logo">Weather Station</a> <!--nom de la station météo-->
		  <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
		  <ul id="nav-mobile" class="right hide-on-med-and-down">
			<li><a href="Info_syst.php">Informations système</a></li>
			<li><a href="Version.php">Version</a></li>
		  </ul>
		</div>
		<div class="nav-content"> <!--onglets-->
		  <ul class="tabs tabs-transparent">
			<li class="tab"><a class="active"href="#Home">Résumé</a></li>
			<li class="tab"><a class="active" href="#Ext">Extérieur</a></li>
			<li class="tab"><a class="active"href="#Salon">Salon</a></li>
			<li class="tab"><a class="active"href="#Chambre">Chambre</a></li>
		  </ul>
		</div>
	 </nav>

	<ul class="sidenav" id="mobile-demo"> <!-- menu défilant sur les petits écran-->
		<ul class="collection">
			<li class="collection-item avatar">
				<img src="icones/Blue_Cloud.png" alt="" class="circle">
				<span class="title blue-text text-darken-2"><b>Weather 'Math' Station</b></span>
				<p class="blue-text text-darken-2">By Mamath
				</p>
			</li>
		</ul>
		<li><a class="blue-text text-darken-2" href="Info_syst.php">Informations système</a></li>
		<li><a class="blue-text text-darken-2" href="Version.php">Version</a></li>
	</ul>

    <div id="Home" class="col s12"> <!--affichage de la date-->
		<div class="row">
			<h3 class="center-align blue-text text-darken-2 col s12">
				 <?php echo $date; ?> 
			</h3>
		</div>
	</div>
	<div class="row">
		<div class="col s1 m3 l3"></div>
		<div class="col s2 m1 l1">
		<img class="responsive-img right" src="icones/sunrise_1.png"/>
		</div>
		<div class="col s3 m2 l2">
			<h4 class="blue-text text-darken-2 left-align"> <?php echo $Sunrise; ?></h4>
		</div>
		<div class="col s2 m2 l2">
			<img class="responsive-img right" src="icones/sunset_1.png"/>
		</div>
		<div class="col s3 m3 l3">
			<h4 class="blue-text text-darken-2 left-align"> <?php echo $Sunset; ?>  </h4>
		</div>
		<div class="col s1 m1 l1"></div>
		
		
	</div>
			
	<div class="row center"> <!--affichage du récapitulatif des variables-->
		<br />
	
		<div class="col s4 m4 l4"> <!--colonne 1-->
			<img class="responsive-img" src="icones/degree.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Températures Salon</h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $temp1; ?>°C</h4>
			
			<br />
			
			<img class="responsive-img" src="icones/Hum_int.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Humidité <br /> Salon</h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $hum; ?>%</h4>
		</div>
		<div class="col s4 m4 l4"> <!--Colonne 2-->
			<img class="responsive-img" src="icones/degree.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Températures chambre </h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $Temp_chambre; ?>°C</h4>
			
			<br />
			
			<img class="responsive-img" src="icones/Hum_int.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Humidité<br /> chambre</h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $Hum_chambre; ?>%</h4>
		</div>
		<div class="col s4 m4 l4"> <!--Colonne 2-->
			<img class="responsive-img" src="icones/outside_thermometer_2.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Températures extérieure</h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $Temp_ext; ?>°C</h4>
			
			<br />
			
			<img class="responsive-img" src="icones/house.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Humidité <br /> extérieure</h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $Hum_ext; ?>%</h4>
		</div>

		<!--<div class="col s6 m3 l3">
			<img class="responsive-img" src="icones/gauge.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Pression</h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $pression; ?>hPa</h4>
		</div>-->
		
		
		
		<div class="col s12"> <!--informations système-->
				<h6 class="grey-text text-darken-2 center-align"> <br /> <br /> Dernière synchronisation à <?php echo $CSV_heure ?> </h6>
				<h6 class="grey-text text-darken-2 center-align"> Il reste <b><?php echo $Esp_libre, "\n", $Esp_libre_unit ?></b> de libre sur un total de <b>   <?php echo $Esp_total, "\n", $Esp_total_unit; ?></b> d'espace sur le disque </h6>
				<div class="fixed-action-btn">
					<a class="btn-floating btn-large blue">
					<i class="large material-icons">arrow_drop_up</i>
					</a>
				</div>
		</div>
		
	</div>
	
	<div class="divider"></div>

	<!--********************-->
	<!--***              ***-->
	<!--***   Zone 2     ***-->
	<!--***              ***-->
	<!--********************-->
		
	
    <div id="Ext" class="col s12">
		<h1 class="center-align blue-text text-darken-2 col s12">Données Extérieures</h1>
	</div>
	
	<div class="row center"> <!--affichage du récapitulatif des variables-->
		<div class="col s1 m1 l1"></div>
		<div class="col s5 m5 l5"> <!--colonne 1-->
			<img class="responsive-img" src="icones/outside_thermometer.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Températures <br /> exterieure</h6>
			<h3 class="blue-text text-darken-2 center-align"> <?php echo $Temp_ext; ?>°C</h3>
		</div>
		<div class="col s5 m5 l5"> <!--Colonne 2-->
			<img class="responsive-img" src="icones/house.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Humidité <br /> extérieure</h6>
			<h3 class="blue-text text-darken-2 center-align"> <?php echo $Hum_ext; ?>%</h3>
		</div>
		<div class="col s1 m1 l1"></div>
	</div>
	
	
	
	<div class="row center">
		<div class="col s3 m3 l4"></div>
		
		<script type="text/javascript">

		function sel_courbe(sel) 
		{
			var opt=sel.getElementsByTagName("option" );
			for (var i=0; i<opt.length; i++) 
			{
			  var x=document.getElementById(opt[i].value);
			  if (x) x.style.display="none";
			}
			var cat = document.getElementById(sel.value);
			if (cat) cat.style.display="block";
        }

		</script>
		
		<div class=" center input-field col s6 m6 l4">
			<select onchange="sel_courbe(this)">
			  <option value="0" disabled selected>Durée d'affichage<option>
			  <!--<option value="13">Jours</option>-->
			  <option value="14">Semaine</option>
			  <option value="15">Mois</option>
			  <option value="16">Année</option>
			</select>
		<label class=" center">Choix de la durée d'affichage</label>
		
		
		</div>
		
		<div class="col s3 m3 l4"></div>
	</div>

		
	<!--<div id="13" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température 2 du jour:</h5>
		<img class="responsive-img" src="Graphs/temperature_2_Jour.png"/>
	</div>-->
	
	<div id="14" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température extérieure de la semaine:</h5>
		<img class="responsive-img" src="Graphs/temp_ext_Sem.png"/>
	</div>

	<div id="15" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température extérieure du mois:</h5>
		<img class="responsive-img" src="Graphs/temp_ext_Mois.png"/>
	</div>
	
	<div id="16" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température extérieure du l'année:</h5>
		<img class="responsive-img" src="Graphs/temp_ext_Annee.png"/>
	</div>
	
	<div class="row center">
		<div class="col s3 m3 l4"></div>
		
		<script type="text/javascript">

		function sel_courbe(sel) 
		{
			var opt=sel.getElementsByTagName("option" );
			for (var i=0; i<opt.length; i++) 
			{
			  var x=document.getElementById(opt[i].value);
			  if (x) x.style.display="none";
			}
			var cat = document.getElementById(sel.value);
			if (cat) cat.style.display="block";
        }

		</script>
		
		<div class=" center input-field col s6 m6 l4">
			<select onchange="sel_courbe(this)">
			  <option value="0" disabled selected>Durée d'affichage<option>
			  <!-- <option value="17">Jours</option>-->
			  <option value="18">Semaine</option>
			  <option value="19">Mois</option>
			  <option value="20">Année</option>
			</select>
		<label class=" center">Choix de la durée d'affichage</label>
		
		</div>
		
		<div class="col s3 m3 l4"></div>
	</div>
	
	<!--<div id="17" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité du jour:</h5>
		<img class="responsive-img" src="Graphs/hum_Jour.png"/>
	</div>-->
	
	<div id="18" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité extérieure de la semaine:</h5>
		<img class="responsive-img" src="Graphs/hum_ext_Sem.png"/>
	</div>

	<div id="19" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité extérieure du mois:</h5>
		<img class="responsive-img" src="Graphs/hum_ext_Mois.png"/>
	</div>
	
	<div id="20" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité extérieure du l'année:</h5>
		<img class="responsive-img" src="Graphs/hum_ext_Annee.png"/>
    </div>  
	
	<div class="divider"></div>
	
	<!--********************-->
	<!--***              ***-->
	<!--***   Zone 3     ***-->
	<!--***              ***-->
	<!--********************-->
	
	<div id="Salon" class="col s12">
		<h1 class="center-align blue-text text-darken-2 col s12">Données Salon</h1>
	</div>
	
	<div class="row center"> <!--affichage du récapitulatif des variables-->
		<div class="col s1 m1 l1"></div>
		<div class="col s5 m5 l5"> <!--colonne 1-->
			<img class="responsive-img" src="icones/degree.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Températures <br /> Salon</h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $temp1; ?>°C</h4>
		</div>
		<div class="col s5 m5 l5">
			<img class="responsive-img" src="icones/Hum_int.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Humidité <br /> Salon</h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $hum; ?>%</h4>
		</div>
		<div class="col s1 m1 l1"></div>
	</div>
	
	
	<div class="row center">
		<div class="col s3 m3 l4"></div>
		
		<script type="text/javascript">

		function sel_courbe(sel) 
		{
			var opt=sel.getElementsByTagName("option" );
			for (var i=0; i<opt.length; i++) 
			{
			  var x=document.getElementById(opt[i].value);
			  if (x) x.style.display="none";
			}
			var cat = document.getElementById(sel.value);
			if (cat) cat.style.display="block";
        }

		</script>
		
		<div class=" center input-field col s6 m6 l4">
			<select onchange="sel_courbe(this)">
			  <option value="0" disabled selected>Durée d'affichage<option>
			  <!--<option value="1">Jours</option>-->
			  <option value="2">Semaine</option>
			  <option value="3">Mois</option>
			  <option value="4">Année</option>
			</select>
		<label class=" center">Choix de la durée d'affichage</label>
		
		
		</div>
		
		<div class="col s3 m3 l4"></div>
	</div>

		
	<!--<div id="1" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température du salon du jour:</h5>
		<img class="responsive-img" src="Graphs/temperature_1_Jour.png"/>
	</div>-->
	
	<div id="2" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température du salon de la semaine:</h5>
		<img class="responsive-img" src="Graphs/temperature_1_Sem.png"/>
	</div>

	<div id="3" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température du salon du mois:</h5>
		<img class="responsive-img" src="Graphs/temperature_1_Mois.png"/>
	</div>
	
	<div id="4" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température du salon du l'année:</h5>
		<img class="responsive-img" src="Graphs/temperature_1_Annee.png"/>
	</div>
	
	
	<div class="row center">
		<div class="col s3 m3 l4"></div>
		
		<script type="text/javascript">

		function sel_courbe(sel) 
		{
			var opt=sel.getElementsByTagName("option" );
			for (var i=0; i<opt.length; i++) 
			{
			  var x=document.getElementById(opt[i].value);
			  if (x) x.style.display="none";
			}
			var cat = document.getElementById(sel.value);
			if (cat) cat.style.display="block";
        }

		</script>
		
		<div class=" center input-field col s6 m6 l4">
			<select onchange="sel_courbe(this)">
			  <option value="0" disabled selected>Durée d'affichage<option>
			  <!-- <option value="9">Jours</option>-->
			  <option value="10">Semaine</option>
			  <option value="11">Mois</option>
			  <option value="12">Année</option>
			</select>
		<label class=" center">Choix de la durée d'affichage</label>
		
		</div>
		
		<div class="col s3 m3 l4"></div>
	</div>
	
	<!--<div id="9" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité du jour:</h5>
		<img class="responsive-img" src="Graphs/hum_Jour.png"/>
	</div>-->
	
	<div id="10" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité du mois:</h5>
		<img class="responsive-img" src="Graphs/hum_Sem.png"/>
	</div>

	<div id="11" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité du mois:</h5>
		<img class="responsive-img" src="Graphs/hum_Mois.png"/>
	</div>
	
	<div id="12" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité du l'année:</h5>
		<img class="responsive-img" src="Graphs/hum_Annee.png"/>
    </div>  
	
	
	<div class="divider"></div>
	
	
    
	
	<div class="divider"></div>
	
	<!--********************-->
	<!--***              ***-->
	<!--***   Zone 4     ***-->
	<!--***              ***-->
	<!--********************-->
	
	<div id="Chambre" class="col s12">
		<h1 class="center-align blue-text text-darken-2 col s12"> Données chambre</h1>
	</div>
	
	<div class="row center"> <!--affichage du récapitulatif des variables-->
		<div class="col s1 m1 l1"></div>
		<div class="col s5 m5 l5"> <!--colonne 1-->
			<img class="responsive-img" src="icones/degree.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Températures <br /> chambre </h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $Temp_chambre; ?>°C</h4>
		</div>
		<div class="col s5 m5 l5"> <!--Colonne 2-->
			<img class="responsive-img" src="icones/Hum_int.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Humidité<br /> chambre</h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $Hum_chambre; ?>%</h4>
		</div>
		<div class="col s1 m1 l1"></div>
	</div>

	<div class="row center">
		<div class="col s3 m3 l4"></div>
		
		<script type="text/javascript">

		function sel_courbe(sel) 
		{
			var opt=sel.getElementsByTagName("option" );
			for (var i=0; i<opt.length; i++) 
			{
			  var x=document.getElementById(opt[i].value);
			  if (x) x.style.display="none";
			}
			var cat = document.getElementById(sel.value);
			if (cat) cat.style.display="block";
        }

		</script>
		
		<div class=" center input-field col s6 m6 l4">
			<select onchange="sel_courbe(this)">
			  <option value="0" disabled selected>Durée d'affichage<option>
			  <!--<option value="21">Jours</option>-->
			  <option value="22">Semaine</option>
			  <option value="23">Mois</option>
			  <option value="24">Année</option>
			</select>
		<label class=" center">Choix de la durée d'affichage</label>
		
		
		</div>
		
		<div class="col s3 m3 l4"></div>
	</div>

		
	<!--<div id="21" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température 2 du jour:</h5>
		<img class="responsive-img" src="Graphs/temperature_2_Jour.png"/>
	</div>-->
	
	<div id="22" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température de la chambre de la semaine:</h5>
		<img class="responsive-img" src="Graphs/temp_chambre_Sem.png"/>
	</div>

	<div id="23" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température de la chambre du mois:</h5>
		<img class="responsive-img" src="Graphs/temp_chambre_Mois.png"/>
	</div>
	
	<div id="24" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de la température de la chambre du l'année:</h5>
		<img class="responsive-img" src="Graphs/temp_chambre_Annee.png"/>
	</div>
	
	<div class="row center">
		<div class="col s3 m3 l4"></div>
		
		<script type="text/javascript">

		function sel_courbe(sel) 
		{
			var opt=sel.getElementsByTagName("option" );
			for (var i=0; i<opt.length; i++) 
			{
			  var x=document.getElementById(opt[i].value);
			  if (x) x.style.display="none";
			}
			var cat = document.getElementById(sel.value);
			if (cat) cat.style.display="block";
        }

		</script>
		
		<div class=" center input-field col s6 m6 l4">
			<select onchange="sel_courbe(this)">
			  <option value="0" disabled selected>Durée d'affichage<option>
			  <!-- <option value="25">Jours</option>-->
			  <option value="26">Semaine</option>
			  <option value="27">Mois</option>
			  <option value="28">Année</option>
			</select>
		<label class=" center">Choix de la durée d'affichage</label>
		
		</div>
		
		<div class="col s3 m3 l4"></div>
	</div>
	
	<!--<div id="25" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité du jour:</h5>
		<img class="responsive-img" src="Graphs/hum_Jour.png"/>
	</div>-->
	
	<div id="26" class="center col s12">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité de la chambre de la semaine:</h5>
		<img class="responsive-img" src="Graphs/hum_chambre_Sem.png"/>
	</div>

	<div id="27" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité de la chambre du mois:</h5>
		<img class="responsive-img" src="Graphs/hum_chambre_Mois.png"/>
	</div>
	
	<div id="28" class="center col s12" style="display:none">
		<h5 class="center-align blue-text text-darken-2 col s12"> l'évolution de l'humidité de la chambre du l'année:</h5>
		<img class="responsive-img" src="Graphs/hum_chambre_Annee.png"/>
    </div> 
	
	
	  
	<div class="col s12"> <!--informations système-->
		<div class="fixed-action-btn">
			<a href="#Home" class="btn-floating btn-large blue">
			<i class="large material-icons Medium">arrow_drop_up</i>
			</a>
		</div>
	</div>
	  
	</body>
	 <script type="text/javascript">
	 // Script bouton flottant
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