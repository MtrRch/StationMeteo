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
	  
		<style type="text/css" media="screen">
		body {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
		}

		#chartdiv {
		width: 100%;
		height: 500px;
		}
		#chartdiv2 {
		width: 100%;
		height: 500px;
		}
		</style>
    </head>
	
	<?php 
		// Execute un refresh de la page en PHP

		//$delai=60;  // délai en secondes
		//header("Refresh: $delai;");
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
			<img class="responsive-img" src="icones/thermometer.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Températures Salon</h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $temp1; ?>°C</h4>
			
			<br />
			
			<img class="responsive-img" src="icones/Hum_int.png"/>
			<h6 class="blue-text text-darken-2 center-align"> Humidité <br /> Salon</h6>
			<h4 class="blue-text text-darken-2 center-align"> <?php echo $hum; ?>%</h4>
		</div>
		<div class="col s4 m4 l4"> <!--Colonne 2-->
			<img class="responsive-img" src="icones/thermometer.png"/>
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
				<h6 class="grey-text text-darken-2 center-align"> <br /> <br /> Dernière synchronisation: <?php echo $CSV_date ?> </h6>
				<h6 class="grey-text text-darken-2 center-align"> Il reste <b><?php echo $Esp_libre, "\n", $Esp_libre_unit ?></b> de libre sur un total de <b>   <?php echo $Esp_total, "\n", $Esp_total_unit; ?></b> d'espace sur le disque </h6>
				<div class="fixed-action-btn">
					<a class="btn-floating btn-large blue">
					<i class="large material-icons">arrow_drop_up</i>
					</a>
				</div>
		</div>
		
	</div>
	
	<div class="divider"></div>
	
	<div class="col s12">
		<h1 class="center-align blue-text text-darken-2 col s12"> Graphiques d'évolution</h1>
	</div>
	
	<div id="chartdiv"></div> <!--Graph températures-->

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
			<img class="responsive-img" src="icones/outside_thermometer_2.png"/>
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
	<!--********************-->
	<!--***              ***-->
	<!--***   Zone 5     ***-->
	<!--***              ***-->
	<!--********************-->
	

	
	  
	<div class="col s12"> <!--informations système-->
		<div class="fixed-action-btn">
			<a href="#Home" class="btn-floating btn-large blue">
			<i class="large material-icons Medium">arrow_drop_up</i>
			</a>
		</div>
	</div>
	  
	</body>
		<script src="js/core.js"></script> <!--lib pour la génération de graph-->
		<script src="js/charts.js"></script> <!--lib pour la génération de graph-->
		<script src="js/animated.js"></script> <!--lib pour la génération de graph-->
		
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
	
	<script type="text/javascript">
			// Themes begin
			am4core.useTheme(am4themes_animated);
			// Themes end
			
			//
			//////////////////////////////
			// Create chart temp instance//
			//////////////////////////////
			//
			
			var chart = am4core.create("chartdiv", am4charts.XYChart);
			
			chart.paddingRight = 20;
			

			// Set up data source
			chart.dataSource.url = "export_donnees_SenseHat.csv";
			chart.dataSource.parser = new am4core.CSVParser();
			chart.dataSource.parser.options.useColumnNames = false;
			

			// Create axes
			var DateAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			DateAxis.dataFields.category = "col0";
		
			DateAxis.renderer.labels.template.rotation = 45;
			

			// Create value axis
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
			valueAxis.tooltip.disabled = true;
			valueAxis.title.text = "Température";
			valueAxis.max = 95;

			// Create series
			var series1 = chart.series.push(new am4charts.LineSeries());
			series1.dataFields.valueY = "col5";
			series1.dataFields.categoryX = "col0";
			series1.name = "température extérieur";
			series1.strokeWidth = 1;
			series1.tensionX = 0.7;
			series1.fillOpacity = 0.1;
			series1.tooltipText = "temperature: [bold]{valueY}[/]";
			
			
			var series2 = chart.series.push(new am4charts.LineSeries());
			series2.dataFields.valueY = "col1";
			series2.dataFields.categoryX = "col0";
			series2.name = "température salon";
			series2.strokeWidth = 1;
			series2.tensionX = 0.7;
			series2.fillOpacity = 0.1;
			series2.tooltipText = "temperature: [bold]{valueY}[/]";
			//series2.hidden = true;
			
			var series3 = chart.series.push(new am4charts.LineSeries());
			series3.dataFields.valueY = "col7";
			series3.dataFields.categoryX = "col0";
			series3.name = "température chambre";
			series3.strokeWidth = 1;
			series3.tensionX = 0.7;
			series3.fillOpacity = 0.1;
			series3.tooltipText = "temperature: [bold]{valueY}[/]";
			//series3.hidden = true;
			
			// Create series
			var series4 = chart.series.push(new am4charts.LineSeries());
			series4.dataFields.valueY = "col6";
			series4.dataFields.categoryX = "col0";
			series4.name = "Humidité extérieur";
			series4.strokeWidth = 1;
			series4.tensionX = 0.7;
			series4.fillOpacity = 0.1;
			series4.tooltipText = "humidité: [bold]{valueY}[/]";
			series4.hidden = true;
			
			var series5 = chart.series.push(new am4charts.LineSeries());
			series5.dataFields.valueY = "col3";
			series5.dataFields.categoryX = "col0";
			series5.name = "humidité salon";
			series5.strokeWidth = 1;
			series5.tensionX = 0.7;
			series5.fillOpacity = 0.1;
			series5.tooltipText = "humidité: [bold]{valueY}[/]";
			series5.hidden = true;
			
			var series6 = chart.series.push(new am4charts.LineSeries());
			series6.dataFields.valueY = "col8";
			series6.dataFields.categoryX = "col0";
			series6.name = "humidité chambre";
			series6.strokeWidth = 1;
			series6.tensionX = 0.7;
			series6.fillOpacity = 0.1;
			series6.tooltipText = "humidité: [bold]{valueY}[/]";
			series6.hidden = true;
			
			chart.cursor = new am4charts.XYCursor();
			chart.cursor.lineY.opacity = 0;
			chart.cursor.behavior = "none";
			chart.scrollbarX = new am4core.Scrollbar();
			
			chart.events.on("datavalidated", function () {
			dateAxis.zoom({start:0.8, end:1});
			});
			
			// Add legend
			chart.legend = new am4charts.Legend();
		</script>
  </html