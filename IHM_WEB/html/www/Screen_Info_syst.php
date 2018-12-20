<!DOCTYPE html>
  <html>
    <head>
      
	    <title>Weather Station</title>
		<link rel="icon" type="image/png" href="icones/favicon_cloud.png" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		<meta http-equiv="Content-Language" content="Fr"/>
		<meta name="Author" lang="fr" content="Mathieu"/>
		<meta name="Copyright" content="©Mathieu"/>
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
	  
	  <script type="text/javascript" src="reboot.js"></script>
	  
    </head>
	
	<?php
	//Informations CPU
		// Nom du CPU 
		$cpuinfo = file('/proc/cpuinfo');
		$cpu = substr($cpuinfo[1],13);
		
		$temp_cpu = shell_exec('cat /sys/class/thermal/thermal_zone0/temp');
		$temp_cpu = round($temp_cpu/1000,1);
		
		
		$cpu_avg = sys_getloadavg();
		$cpu_usage = $cpu_avg[0];
		$cpu_usage = (1-$cpu_usage) * 100;

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
	
	$Adresse_IP = $_SERVER['SERVER_ADDR'];
	
	?>
	
	<body>

	<nav>
		<div class="nav-wrapper red">
		  <a href="#" class="brand-logo left">Weather 'Pi' Station</a>
		  <ul id="nav-mobile" class="right">
			<li><a href="Screen.php#Home">Station météo</a></li>
		  </ul>
		</div>
	  </nav>
	  
	<div class="row ">
		<div class="col s1 m1 l1"></div>
		
		<div class="col s10 m10 l10"> <!--titre de la page-->
			<h2 class="red-text text-darken-2 center-align "> <b>Informations système</b></h2>		  
		</div>
		
		<div class="col s1 m1 l1"></div>

	</div>	
	  
	 <div class="row center"> <!--informations utile-->
		<div class="col s4">
			<h4 class="red-text text-darken-2 center-align "> <b> Informations CPU</b><br /><br /> </h4>
			
			<h6 class="red-text text-darken-2 center-align "> CPU:<br /><b> <?php echo $cpu;?></b></h6>
			<!--<h6 class="red-text text-darken-2 center-align "> Charge du CPU: <b><?php //echo $cpu_usage;?>%</b> </h6>-->
			<h6 class="red-text text-darken-2 center-align "> Température du CPU: <b><?php echo $temp_cpu;?>°C</b> </h6>	
		</div>
		<div class="col s4">
			<h4 class="red-text text-darken-2 center-align "> <b>Informations mémoire</b><br /><br /></h4>	
			
			<h6 class="red-text text-darken-2 center-align "> Espace total <b>:   <?php echo $Esp_total, "\n", $Esp_total_unit; ?></b></h6>
			<h6 class="red-text text-darken-2 center-align "> Espace libre:   <b><?php echo $Esp_libre, "\n", $Esp_libre_unit ?></b> </h6>
			<h6 class="red-text text-darken-2 center-align "> Taille du fichier CSV:   <b><?php echo $Esp_csv, "\n", $Esp_csv_unit; ?></b> </h6>
		</div>
		
		<div class="col s4">
			<h4 class="red-text text-darken-2 center-align "> <b>Informations Réseau</b><br /><br /></h4>
			
			<h6 class="red-text text-darken-2 center-align "> Adresse IP: <b><?php echo $Adresse_IP;?></b> </h6>
		</div>
	</div>	
	  
	  
	  
	  
	  
	  
	 <div class="row right">
		<div class="col s12 m12 l12">
			<div class="fixed-action-btn">
				<a class="btn-floating btn-large red">
				<i class="large material-icons">filter_list</i>
			</a>
			<ul>
				<li><a class="btn-floating yellow darken-1" onclick="reboot();"><i class="material-icons">refresh</i></a></li>
				<li><a class="btn-floating blue"><i onclick="shutdown();" class="material-icons">power_settings_new</i></a></li>
			</ul>
		</div>
	</div>	 
	  
  
	  
	  
	  
	</body>
	 <script type="text/javascript">
	 // Script bouton flottant
	document.addEventListener('DOMContentLoaded', function() 
	{
		var elems = document.querySelectorAll('.fixed-action-btn');
		var instances = M.FloatingActionButton.init(elems, 
		{
		  direction: 'left',
		  hoverEnabled: false
		});
	});
	</script>
	
    <script type="text/javascript" src="js/materialize.js"></script>
  </html