PREREQUIS:
	- Installation d'un serveur apache + php
	- Installer "Domoticz" etajouter les capteurs (eventuellement modifier le script) --> http://blogmotion.fr/diy/jq-api-json-14942



IHM_WEB --> site web html

	Il est n�cessaire de copier le contenue de ce r�pertoire sur le Pi dans le r�pertoire "/var/www/html" 

Arboressence:
	|	
	|--/CSS : contient les fichiers de mise en forme (majoritairement issue de materialize)
	|	
	|--/export_donnees_SenseHat.csv : lien symbolique vers le fichier du m�me nom sous "home/pi/Desktop/SenseHat"
	|	
	|--/Graphs: lien symbolique vers le r�pertoire du m�me nom sous "home/pi/Desktop/SenseHat"
	|	
	|--/icones: contient les iconnes utilis�es sur le site web
	|	
	|--/js : contient les fichiers javascript (majoritairement issue de materialize)
	|	
	|--index.php: Page WEB principale du site, contient les information sur les capteurs, les courbres et quelques autres informations
	|	
	|--Info_syst.php: information syst�me sur la station m�t�o (onglet sur le site web)
	|	
	|--LICENSE: n�cessaire pour l'utilisaton de materialize
	|	
	|--README.md: n�cessaire pour l'utilisaton de materialize
	|	
	|--reboot.js: Script javascript contenant les fonction de reboot et shutdown (il apelle les scripts php qui lance les commandes syst�me)
	|		
	|--reboot.php: contient la commande de reboot, est appel� par "reboot.js"
	|		
	|--shutdown.php: contient la commande de shutdown, est appel� par "reboot.js"
	|
	|--Version.php: Ongle du site web contenant les information de version de la station m�t�o





TRT_Python --> programmes d�velopp� majoritairement en python permettant de faire fonctionnner la station m�t�o (acquisition des donn�es, mise en forme, enregistrement ...)

	Il est n�cessaire de copier le r�pertoire SenseHat sur le bureau ("/home/pi/Desktop")

Arboressence:
	|	
	|-- /Graphs: Dossier contenant les graphique g�n�r� au format PNG
	|
	|-- Capteur_distant.txt : Fichier dans lequel les valeurs en provenance des capteur distant sont stock�es (utilis� par le script "Spt_acq_domoticz.sh")
	|	
	|-- export_donnees_SenseHat.csv: fichier contenant toutes les valeurs enregistr�es des capteurs
	|
	|-- SenseEmu_stick.py: programme main utilis� en l'absence de la carte "SenseHat" avec le simulateur int�gr� � la distribution "Raspbian"
	|
	|-- SenseHat_Main.py: programme principal cr�ant et remplissant le fichier CSV avec les donn�es des capteurs et g�n�rant les courbes
	|
	|-- Script_acq_domoticz.sh: Script permettant de r�cup�rer les donn�es des capteur distant (communiquant par onde radio 433MHz) et connect� au logiciel "Domoticz"
	|	