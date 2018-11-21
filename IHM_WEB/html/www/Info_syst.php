<!DOCTYPE html>
  <html>
    <head>
      
	    <title>Weather Station</title>
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
	
	$Adresse_IP = $_SERVER['SERVER_ADDR']
	
	?>
	
	<body>

	<nav class="nav-extended red">
		<div class="nav-wrapper">
		  <a href="#" class="brand-logo">Weather Station</a>
		  <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
		  <ul id="nav-mobile" class="right hide-on-med-and-down">
			<li><a href="index.php">Station Météo</a></li>
			<li><a href="Version.php">Version</a></li>
		  </ul>
		</div>
	</nav>

	<ul class="sidenav" id="mobile-demo">
		<ul class="collection">
			<li class="collection-item avatar">
				<img src="icones/Red_Cloud.png" alt="" class="circle">
				<span class="title red-text text-darken-2"><b>Weather 'Math' Station</b></span>
				<p class="red-text text-darken-2">By Mamath
				</p>
			</li>
		</ul>
		<li><a class="red-text text-darken-2" href="index.php">Station Météo</a></li>
		<li><a class="red-text text-darken-2" href="Version.php">Version</a></li>
	</ul>
	  
	<div class="row ">
		<div class="col s1 m1 l1"></div>
		
		<div class="col s10 m10 l10"> <!--titre de la page-->
			<h1 class="red-text text-darken-2 center-align "> <b>Informations système</b></h1>		  
		</div>
		
		<div class="col s1 m1 l1"></div>

	</div>	
	  
	 <div class="row center"> <!--informations utile-->
		<div class="col s12">
			<h4 class="red-text text-darken-2 center-align "> <b> Informations CPU</b> </h4>
			<br />
			<h6 class="red-text text-darken-2 center-align "> CPU:<br /><b> <?php echo $cpu;?></b></h6>
			<!--<h6 class="red-text text-darken-2 center-align "> Charge du CPU: <b><?php //echo $cpu_usage;?>%</b> </h6>-->
			<h6 class="red-text text-darken-2 center-align "> Température du CPU: <b><?php echo $temp_cpu;?>°C</b> </h6>
			<br />
			
			<h4 class="red-text text-darken-2 center-align "> <b>Informations mémoire</b></h4>	
			
			<h6 class="red-text text-darken-2 center-align "> Espace total <b>:   <?php echo $Esp_total, "\n", $Esp_total_unit; ?></b></h6>
			<h6 class="red-text text-darken-2 center-align "> Espace libre:   <b><?php echo $Esp_libre, "\n", $Esp_libre_unit ?></b> </h6>
			<h6 class="red-text text-darken-2 center-align "> Taille du fichier CSV:   <b><?php echo $Esp_csv, "\n", $Esp_csv_unit; ?></b> </h6>
			<br />	

			<h4 class="red-text text-darken-2 center-align "> <b>Informations Réseau</b></h4>
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
				<li><a class="btn-floating green" href="export_donnees_SenseHat.csv"><i class="material-icons">file_download</i></a></li>
				<li><a class="btn-floating yellow darken-1" onclick="restart()"><i class="material-icons">refresh</i>
					<script>
						function restart() 
						{						
							if (confirm("Veux-tu vraiment redémarrer la station?"))
							{
								<?php //exec('sudo -u www-data /sbin/reboot'); ?>
								
							}
							
						}
					</script>
				</a></li>
				<li><a class="btn-floating blue"><i onclick="poweroff()" class="material-icons">power_settings_new</i>
					<script>
						function poweroff() 
						{	
							if (confirm("Veux-tu vraiment redémarrer la station?"))
							{
								<?php //system('sudo -u www-data /sbin/poweroff');?>
							}
							
						}
					</script>
				
				</a></li>
				<!--<li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>-->
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