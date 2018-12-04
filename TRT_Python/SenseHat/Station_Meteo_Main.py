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
    wtr = csv.writer(file, delimiter='|') # création du writer
    print("Le fichier '%s' existe"%fname)
    file.close() 

else: #Si non, on créer le fichier + l'entête
    file = open(fname, "at") # Ouverture du csv
    wtr = csv.writer(file, delimiter='|') # création du writer
    wtr.writerow(('date','heure','température 1', 'température 2', 'humidité', 'pression', 'température exterieure', 'humidité exterieure', 'température chambre', 'humidité chambre')) #Ecriture de la 1ère ligne (titre des colonnes
    file.close() 

#  
# Fin création du fichier "*.csv"
#
 
min_ref =  int(time.strftime("%M"))
#
# Génération des graphs appel dans le while
#
 
def Generation_Graph(fname,Axe_Y,Prefix):
    annee_courant = int(time.strftime("%Y"))
    mois_courant = int(time.strftime("%m"))
    semaine_courant  = int(time.strftime("%W"))
    Nb_heures_Jour = 1 # 1 journée
    Nb_Jours_Sem = 7 # Semaine = 7 jours
    Nb_Jours_Mois_Courant = calendar.monthrange(int(annee_courant),int(mois_courant))[1] #obtention du nombre de jour dans un mois
    Nb_Jours_Annee_Courant = dt.datetime(annee_courant,12,31)- dt.datetime(annee_courant,1,1) # Nombre de jour dans l'année courante
    Nb_Jours_Annee_Courant = Nb_Jours_Annee_Courant/timedelta(days=1)

    df = pd.read_csv(fname,sep='|',parse_dates=['date','heure'], header=0, names=['date','heure','température 1','température 2','humidité','pression', 'température exterieure', 'humidité exterieure', 'température chambre', 'humidité chambre'])
    #print (df)
                                                          
    fig_1 = df.plot(x='date',y=Axe_Y, figsize = (10, 5))
    
    xmin, xmax = plt.xlim() #initialisation des variables xmin, xmax (valeur min/max de l'axe "X") avec la valeur actuel

    row_max,column = df.shape #obtention du nombre de ligne et de colonne du csv
    row_max = row_max-1 #N° de la ligne max du csv

    xmax=df['date'].iloc[row_max] # Valeur de la dernière ligne de la colonne 'date'
    xmax = xmax.to_pydatetime() #convertion du timestamp obtenue en date 1/2
    xmax=xmax.date()#convertion du timestamp obtenue en date 2/2

    date_min = df['date'].iloc[0] # Valeur de la première ligne de la colonne date
    date_min = date_min.to_pydatetime() #convertion du timestamp obtenue en date
    date_min=date_min.date()#convertion du timestamp obtenue en date

    
    #
    ## Génération des graphs
    #

    plt.grid()
    plt.xlabel('date')
    plt.ylabel(Axe_Y)
    plt.tight_layout()
       
    if xmax-relativedelta(days=Nb_Jours_Sem)<date_min: # Si on a pas le delta de jour d'enregistrement
        #print("Evolution sur une semaine:il manque malheuresement des valeurs pour afficher toute la plage")
        xmin = date_min
    else:
        xmin = xmax - relativedelta(days=Nb_Jours_Sem) # si on a plus que le delta de jour en enregistrement
                
    plt.xlim(xmin,xmax) # On "zoom"
    chemin="/home/pi/Desktop/SenseHat/Graphs/%s_Sem.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe

    
    if xmax-relativedelta(days=Nb_Jours_Mois_Courant)<date_min: # Si on a pas le delta de jour d'enregistrement    print("il manque des valeurs pour afficher toute la plage")
        xmin = date_min
        #print("Evolution sur un mois:il manque malheuresement des valeurs pour afficher toute la plage")
    else:
        xmin = xmax - relativedelta(days=Nb_Jours_Mois_Courant) # si on a plus que le delta de jour en enregistrement
                
    plt.xlim(xmin,xmax) # On "zoom"
    chemin="/home/pi/Desktop/SenseHat/Graphs/%s_Mois.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe

    if xmax-relativedelta(days=Nb_Jours_Annee_Courant)<date_min: # Si on a pas le delta de jour d'enregistrement
        #print("Evolution sur une année:il manque malheuresement des valeurs pour afficher toute la plage")
        xmin = date_min
    else:
        xmin = xmax - relativedelta(days=Nb_Jours_Annee_Courant) # si on a plus que le delta de jour en enregistrement
                
    plt.xlim(xmin,xmax) # On "zoom"
    chemin="/home/pi/Desktop/SenseHat/Graphs/%s_Annee.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe
    
    plt.close('all')
 
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
  
  date  = time.strftime("%d/%m/%Y")
  heure  = time.strftime("%X")
  min = int(time.strftime("%M"))
  
  # Remplissagge du fichier csv avec les variables
  
  if min_ref+Interval >= 60: #la variable "min" étant comprise entre 0 et 60 "min_ref ne doit pas dépasser 59
      min_ref = 00
          
  if min == min_ref+Interval:
      os.system('bash /home/pi/Desktop/SenseHat/Script_acq_domoticz.sh') # On lance le script qui récupère les donnée sur domoticz et les inscrit dans un fichier txt
      
      Generation_Graph(fname,'température 1','temperature_1')      #Génération des courbes tepérature Salon
      Generation_Graph(fname,'humidité','hum')                     #Génération des courbes humidité Salon
      Generation_Graph(fname,'température exterieure','temp_ext')  #Génération des courbes pression
      Generation_Graph(fname,'humidité exterieure','hum_ext')      #Génération des courbes pression
      Generation_Graph(fname,'température chambre','temp_chambre') #Génération des courbes pression
      Generation_Graph(fname,'humidité chambre','hum_chambre')     #Génération des courbes pression
      
      file = open(fname, "at") # Ouverture du csv
      wtr = csv.writer(file, delimiter='|') # création du writer
      
      concat = ["{0}|{1}|{2}|{3}|{4}|{5}|{6}|{7}|{8}|{9}".format(date,heure,Temp_Salon, temp_hum, Hum_Salon, press, Temp_ext,Hum_ext,Temp_chambre,Hum_chambre)] # Création de la ligne concaténant toutes les variables qui sera écrite dans le CSV
      print("concat = %s" %concat) # On l'affiche #JustToCheck #AuCasOu

      wtr.writerows(i.strip().split('|') for i in concat)
      
      min_ref = int(time.strftime("%M"))
      
        
  file.close() #Fermeture du  CSV
        
        


