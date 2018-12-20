<!DOCTYPE html>
  <html>
    <head>
      
	    <title>Weather Station</title>
		<link rel="icon" type="image/png" href="icones/Screen/favicon_cloud.png" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		<meta http-equiv="Content-Language" content="Fr"/>
		<meta name="Author" lang="fr" content="Mathieu"/>
		<meta name="Copyright" content="© Mathieu"/>
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0">
		
		<!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	  
		<script src="js/jquery.js"></script>
	  
	  	<style type="text/css"> <!--Suppression de la bar de défilement horizontale-->
		body {
		overflow-x:hidden;
		}
		</style>
	  
    </head>
	
	<?php 
		// Execute un refresh de la page en PHP

		$delai=60;  // délai en secondes
		header("Refresh: $delai;");
	?>
	
	<?php //Relecture de la dernière ligne du CSV + inscription dans les variables
			$ligne = 1; // compteur de ligne
			$fic = fopen("export_donnees_SenseHat.csv", "r"); //Ouverture du fichier en lecture
			while($tab=fgetcsv($fic,0,','))
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
				$temp1 = $tab[1];
				$temp2 = $tab[2];
				$hum= $tab[3];
				$pression = $tab[4];
				$Temp_ext= $tab[5];
				$Hum_ext= $tab[6];
				$Temp_chambre= $tab[7];
				$Hum_chambre= $tab[8];
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
	
	<?php // Informations réseau
	
	$command="/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";
	$Adresse_IP = exec ($command);

		
	?>
	
	<body>
	

	
	  <nav>
		<div class="nav-wrapper blue">
		  <a href="#" class="brand-logo left">Weather 'Pi' Station</a>
		  <ul id="nav-mobile" class="right">
			<li><a href="Screen_Info_syst.php">Informations système</a></li>
		  </ul>
		</div>
	  </nav>
	
	<div id="Home" class="col s12"> <!--affichage de la date-->
		<div class="row">
			<h4 class="center-align blue-text text-darken-2 col s12">
				 <?php echo $date; ?> 
			</h4>
		</div>
	</div>
			
	<div class="row center"> <!--affichage du récapitulatif des variables-->
		<br />
	
		<div class="col s3 m3 l3"> <!--colonne 1-->
			<h5 class="blue-text text-darken-2 center-align">Données <br />Salon</h5>
			<img class="responsive-img" src="icones/thermometer.png"/>
			<h5 class="blue-text text-darken-2 center-align"> <?php echo $temp1; ?>°C</h5>
			
			<img class="responsive-img" src="icones/Hum_int.png"/>
			<h5 class="blue-text text-darken-2 center-align"> <?php echo $hum; ?>%</h5>
		</div>
		<div class="col s3 m3 l3"> <!--colonne 1-->
			<h5 class="blue-text text-darken-2 center-align">Données <br />Chambre <br /></h5>
			<img class="responsive-img" src="icones/thermometer.png"/>
			<h5 class="blue-text text-darken-2 center-align"> <?php echo $Temp_chambre; ?>°C</h5>
			
			<img class="responsive-img" src="icones/Hum_int.png"/>
			<h5 class="blue-text text-darken-2 center-align"> <?php echo $Hum_chambre; ?>%</h5>
		</div>
		<div class="col s3 m3 l3"> <!--colonne 1-->
			<h5 class="blue-text text-darken-2 center-align">Données <br />Extérieur <br /></h5>
			<img class="responsive-img" src="icones/outside_thermometer_2.png"/>
			<h5 class="blue-text text-darken-2 center-align"> <?php echo $Temp_ext; ?>°C</h5>
			
			<img class="responsive-img" src="icones/house.png"/>
			<h5 class="blue-text text-darken-2 center-align"> <?php echo $Hum_ext; ?>%</h5>
		</div>
		<div class="col s3 m3 l3"> <!--colonne 1-->
		<h5 class="blue-text text-darken-2 center-align"> Lever/coucher du soleil</h5>
			<img class="responsive-img" src="icones/sunrise_1.png"/>
			<h5 class="blue-text text-darken-2 center-align"> <?php echo $Sunrise; ?></h5>
			
			<img class="responsive-img" src="icones/sunset_1.png"/>
			<h5 class="blue-text text-darken-2 center-align"> <?php echo $Sunset; ?>  </h5>
		</div>

		
		
		<div class="row center">
			<div class="col s5"> <!--informations système-->
					<h6 class="grey-text text-darken-2 center-align"><br />Pour plus d'informations: <b>192.168.1.7</b></h6>
					<!--<h6 class="grey-text text-darken-2 center-align"> Pour plus d'informations: <b>192.168.1.7</b></h6>-->
			</div>
			
			<div class="col s5"> <!--informations système-->
				<h6 class="grey-text text-darken-2 center-align"><br />Dernière synchro: <?php echo $CSV_date ?> </h6>
				<!--<h6 class="grey-text text-darken-2 center-align"> Pour plus d'informations: <b>192.168.1.7</b></h6>-->
			</div>
			<div class="col s2">
				<div class="fixed-action-btn">
					<a href="#Home" class="btn-floating btn-medium waves-effect waves-light blue">
					<i class="large material-icons">expand_less</i>
					</a>
				</div>
			</div>
		</div>
		
	</div>
	</body>
	
	<script type="text/javascript">
		// Script pour le 'sidenav'
		$(document).ready(function()
		{
			$('.sidenav').sidenav();
		});
    </script>
	
	<script type="text/javascript">
		 // Script bouton flottant
		$(document).ready(function()
		{
			$('.fixed-action-btn').floatingActionButton();
		});
	</script>
