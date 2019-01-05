#!/bin/python

########################################################
#
# Programe "main" de la station météo dev par Math
#
########################################################

from dateutil.relativedelta import relativedelta
from datetime import datetime,timedelta

import time
import pygame
import csv
import os
import pandas as pd
import datetime as dt
import calendar
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt



Interval = 5 #interval de capture pour le CSV en minutes

os.system('bash /home/pi/Desktop/SenseHat/Script_acq_domoticz.sh') # On lance le script qui récupère les donnée sur domoticz et les inscrit dans un fichier


annee_enreg = time.strftime("%Y") #Année courante

fname = "/home/pi/Desktop/SenseHat/export_donnees_SenseHat.csv" #Nom du fichier "*.csv" dans lequel écrire

#
# Création du fichier "*.csv"
#

if os.path.isfile(fname): #Test si le fichier existe, si oui on ne fait rien
    file = open(fname, "at") # Ouverture du csv
    wtr = csv.writer(file, delimiter=',') # création du writer
    print("Le fichier '%s' existe"%fname)
    file.close() 

else: #Si non, on créer le fichier + l'entête
    file = open(fname, "at") # Ouverture du csv
    wtr = csv.writer(file, delimiter=',') # création du writer
    wtr.writerow(('date','température 1', 'température 2', 'humidité', 'pression', 'température exterieure', 'humidité exterieure', 'température chambre', 'humidité chambre')) #Ecriture de la 1ère ligne (titre des colonnes
    file.close() 

#  
# Fin création du fichier "*.csv"
#
 
min_ref =  int(time.strftime("%M"))
 
#
# Code
#

while True:
  #os.system('bash /home/pi/Desktop/SenseHat/Script_acq_domoticz.sh') # On lance le script qui récupère les donnée sur domoticz et les inscrit dans un fichier
  temp_hum = 25 #Non utilisé pour le moment prédispo
  press = 1000 #Non utilisé pour le moment prédispo
  
  
  #Obtentien des valeur capteurs distant

  Fichier = open("/home/pi/Desktop/SenseHat/Capteur_distant.txt", "r") # On ouvre le fichier précédement créé

  Valeurs_capteurs = Fichier.readlines() # On lit toute les ligne et les met dans un tableau
 
  #print (Valeurs_capteurs)
 
  Hum_ext = int(Valeurs_capteurs[1]) # inscription de la 2ème ligne dans la variable
  Temp_ext = float(Valeurs_capteurs[3])# inscription de la 3ème ligne dans la variable
  
  Hum_chambre = int(Valeurs_capteurs[5])
  Temp_chambre = float(Valeurs_capteurs[7])
  
  Hum_Salon = int(Valeurs_capteurs[9])
  Temp_Salon = float(Valeurs_capteurs[11])
  
  Fichier.close()
  
  date  = time.strftime("%d/%m/%Y %X")
  heure  = time.strftime("%X")
  min = int(time.strftime("%M"))
  
  # Remplissagge du fichier csv avec les variables
  
  if min_ref+Interval >= 60: #la variable "min" étant comprise entre 0 et 60 "min_ref ne doit pas dépasser 59
      min_ref = 00
          
  if min == min_ref+Interval:
      os.system('bash /home/pi/Desktop/SenseHat/Script_acq_domoticz.sh') # On lance le script qui récupère les donnée sur domoticz et les inscrit dans un fichier txt
      
      file = open(fname, "at") # Ouverture du csv
      wtr = csv.writer(file, delimiter=',') # création du writer
      
      concat = ["{0},{1},{2},{3},{4},{5},{6},{7},{8}".format(date,Temp_Salon, temp_hum, Hum_Salon, press, Temp_ext,Hum_ext,Temp_chambre,Hum_chambre)] # Création de la ligne concaténant toutes les variables qui sera écrite dans le CSV
      print("concat = %s" %concat) # On l'affiche #JustToCheck #AuCasOu

      wtr.writerows(i.strip().split(',') for i in concat)
      
      min_ref = int(time.strftime("%M"))

      file.close() #Fermeture du  CSV      
        
file.close() #Fermeture du  CSV
