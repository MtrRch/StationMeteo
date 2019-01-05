PREREQUIS:
	- Installation d'un serveur apache + php
	- Installer "Domoticz" et ajouter les capteurs (eventuellement modifier le script) --> http://blogmotion.fr/diy/jq-api-json-14942
	- Modification du fichier /etc/rc.local pour lancer le script au démarrage de linux (fichier enregistré sous GIT répertoire "LINUX")
	- lancer chromium en mode Kiosk (plein écran) au démarrage à la page d'index de l'IHM


IHM_WEB --> site web html

	Il est nécessaire de copier le contenue de ce répertoire sur le Pi dans le répertoire "/var/www/html" 

Arboressence:
	|	
	|--/CSS : contient les fichiers de mise en forme (majoritairement issue de materialize)
	|	
	|--/export_donnees_SenseHat.csv : lien symbolique vers le fichier du même nom sous "home/pi/Desktop/SenseHat"
	|	
	|--/Graphs: lien symbolique vers le répertoire du même nom sous "home/pi/Desktop/SenseHat"
	|	
	|--/icones: contient les iconnes utilisées sur le site web
	|	
	|--/js : contient les fichiers javascript (majoritairement issue de materialize)
	|	
	|--index.php: Page WEB principale du site, contient les information sur les capteurs, les courbres et quelques autres informations
	|	
	|--Info_syst.php: information système sur la station météo (onglet sur le site web)
	|	
	|--LICENSE: nécessaire pour l'utilisaton de materialize
	|	
	|--README.md: nécessaire pour l'utilisaton de materialize
	|	
	|--reboot.js: Script javascript contenant les fonction de reboot et shutdown (il apelle les scripts php qui lance les commandes système)
	|		
	|--reboot.php: contient la commande de reboot, est appelé par "reboot.js"
	|
	|--Screen.php: Interface utilisée pour l'écran tactile
	|
	|--Sreen_Info_syst.php: information système de la station météo utilisé pour l'écran tactile
	|		
	|--shutdown.php: contient la commande de shutdown, est appelé par "reboot.js"
	|
	|--Version.php: Ongle du site web contenant les information de version de la station météo





TRT_Python --> programmes développé majoritairement en python permettant de faire fonctionnner la station météo (acquisition des données, mise en forme, enregistrement ...)

	Il est nécessaire de copier le répertoire SenseHat sur le bureau ("/home/pi/Desktop")

Arboressence:
	|	
	|-- /Graphs: Dossier contenant les graphique généré au format PNG
	|
	|-- Capteur_distant.txt : Fichier dans lequel les valeurs en provenance des capteur distant sont stockées (utilisé par le script "Spt_acq_domoticz.sh")
	|	
	|-- export_donnees_SenseHat.csv: fichier contenant toutes les valeurs enregistrées des capteurs
	|
	|-- Station_Meteo_Main.py: programme principal créant et remplissant le fichier CSV avec les données des capteurs et générant les courbes
	|
	|-- Script_acq_domoticz.sh: Script permettant de récupérer les données des capteur distant (communiquant par onde radio 433MHz) et connecté au logiciel "Domoticz"




LINUX --> Fichiers utilisé dans le cadre de l'utilisation de l'OS (démarrage script/logiciel au boot ...)

Arboressence:
	|	
	|-- rc.local: Commandes lancées au démarrage de l'OS (copier le fichier sous /etc/) --> [info debug] erreur affichées dans le fichier /var/log/syslog (cat /var/log/syslog | grep rc.local)
	|	