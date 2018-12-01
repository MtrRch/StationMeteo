from sense_emu import SenseHat
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
import matplotlib.pyplot as plt

sense = SenseHat()
sense.clear()

Interval = 3 #interval de capture pour le CSV en minutes 

annee_enreg = time.strftime("%Y") #Année courante

fname = "export_donnees_SenseHat.csv" #Nom du fichier "*.csv" dans lequel écrire


#
# Définition des couleurs  
#

R = (255,0,0) # R pour Rouge
O = [255, 127, 0] # O pour Orange 
J = [255, 255, 0] # J pour jaune
V = (0,255,0) # grand V pour Vert
B = (0,0,255)# B pour bleu
I = [75, 0, 130]  # I pour ???
P = [159, 0, 255] # B pour Purple (Violet)
N = (0,0,0) # N pour Noir
W = (255,255,255) # W pour White (Blanc)

#
# Fin définition des couleurs  
#

#
# Création des images
#

# Création de l'image «unité de température»
temp_Unit = [
  N, N, N, N, N, N, N, N, 
  R, R, N, N, R,  R, R, R,
  R, R, N, R, N, N, N, N,
  N, N, N, R, N, N, N, N,
  N, N, N, R, N, N, N, N,
  N, N, N, R, N, N, N, N,
  N, N, N, N, R,  R, R, R,
  N, N, N, N, N,  N, N, N
  ]
  
# Création de l'image «unité de %»
Hum_Unit = [
  N, N, N, N, N, N, N, N, 
  N, V, V, N, N, N, V, N,
  N, V, V, N, N, V, N, N,
  N, N, N, N, V, N, N, N,
  N, N, N, V, N, N, N, N,
  N, N, V, N, N, V, V, N,
  N, V, N, N, N, V, V, N,
  N, N, N, N, N, N, N, N,
  ]
  
# Création de l'image «unité de Pa»
press_Unit = [
  N, N, N, N, N, N, N, N, 
  N, B, B, N, N, N, N, N,
  B, N, N, B, N, N, N, N,
  B, N, N, B, N, N, B, N,
  B, B, B, N, N, B, N, B,
  B, N, N, N, N, B, B, B,
  B, N, N, N, N, B, N, B,
  N, N, N, N, N, N, N, N,
  ]
  
# Création de l'image «Flèche bas»
down = [
  N, N, N, P, P, N, N, N, 
  N, N, N, P, P, N, N, N,
  N, N, N, P, P, N, N, N,
  N, N, N, P, P, N, N, N,
  N, N, N, P, P, N, N, N,
  N, P, P, P, P, P, P, N,
  N, N, P, P, P, P, N, N,
  N, N, N, P, P, N, N, N,
  ]
  
# Création de l'image «Flèche haut»
up = [
  N, N, N, P, P, N, N, N,
  N, N, P, P, P, P, N, N,
  N, P, P, P, P, P, P, N,
  N, N, N, P, P, N, N, N,
  N, N, N, P, P, N, N, N,
  N, N, N, P, P, N, N, N,
  N, N, N, P, P, N, N, N,
  N, N, N, P, P, N, N, N,
  ]
  
  # Création de l'image «Flèche droite»
right = [
  N, N, N, N, N, N, N, N,
  N, N, N, N, N, P, N, N,
  N, N, N, N, N, P, P, N,
  P, P, P, P, P, P, P, P,
  P, P, P, P, P, P, P, P,
  N, N, N, N, N, P, P, N,
  N, N, N, N, N, P, N, N,
  N, N, N, N, N, N, N, N
  ]

# Création de l'image «Flèche gauche»
left = [
  N, N, N, N, N, N, N, N,
  N, N, P, N, N, N, N, N,
  N, P, P, N, N, N, N, N,
  P, P, P, P, P, P, P, P,
  P, P, P, P, P, P, P, P,
  N, P, P, N, N, N, N, N,
  N, N, P, N, N, N, N, N,
  N, N, N, N, N, N, N, N
  ]
 
# Création de l'image «Middle 1»
middle_1 = [
  P, P, P, P, P, P, P, P,
  P, N, N, N, N, N, N, P,
  P, N, N, N, N, N, N, P,
  P, N, N, N, N, N, N, P,
  P, N, N, N, N, N, N, P,
  P, N, N, N, N, N, N, P,
  P, N, N, N, N, N, N, P,
  P, P, P, P, P, P, P, P
  ] 
  
# Création de l'image «Middle 2»
middle_2 = [
  N, N, N, N, N, N, N, N,
  N, P, P, P, P, P, P, N,
  N, P, N, N, N, N, P, N,
  N, P, N, N, N, N, P, N,
  N, P, N, N, N, N, P, N,
  N, P, N, N, N, N, P, N,
  N, P, P, P, P, P, P, N,
  N, N, N, N, N, N, N, N
  ]
  
# Création de l'image «Middle 3»
middle_3 = [
  N, N, N, N, N, N, N, N,
  N, N, N, N, N, N, N, N,
  N, N, P, P, P, P, N, N,
  N, N, P, N, N, P, N, N,
  N, N, P, N, N, P, N, N,
  N, N, P, P, P, P, N, N,
  N, N, N, N, N, N, N, N,
  N, N, N, N, N, N, N, N
  ]  
  
  # Création de l'image «Middle 4»
middle_4 = [
  N, N, N, N, N, N, N, N,
  N, N, N, N, N, N, N, N,
  N, N, N, N, N, N, N, N,
  N, N, N, P, P, N, N, N,
  N, N, N, P, P, N, N, N,
  N, N, N, N, N, N, N, N,
  N, N, N, N, N, N, N, N,
  N, N, N, N, N, N, N, N
  ]

#
# Fin Création des images
#


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
    wtr.writerow(('date','heure','température 1', 'température 2', 'humidité', 'pression')) #Ecriture de la 1ère ligne (titre des colonnes
    file.close() 

#  
# Fin création du fichier "*.csv"
#
 
min_ref =  int(time.strftime("%M"))
min_ref_2 =  int(time.strftime("%M"))

#
# Code
#

#
# Sous fonction de génération des graph PNG
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

    df = pd.read_csv(fname,sep=',',parse_dates=['date','heure'], header=0, names=['date','heure','température 1','température 2','humidité','pression'])
                                                          
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

    if xmax-relativedelta(days=Nb_heures_Jour)<date_min: # Si on a pas le delta de jour d'enregistrement
        print("Evolution sur un jour: il manque malheuresement des valeurs pour afficher toute la plage")
        xmin = date_min
    else:
        xmin = xmax - relativedelta(days=Nb_heures_Jour) # si on a plus que le delta de jour en enregistrement

    print (xmin)
    plt.xlim(xmin,xmax) # On "zoom"
    chemin="Graphs/%s_Jours.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe

    fig_1 = df.plot(x='date',y=Axe_Y, figsize = (10, 5))

    if xmax-relativedelta(days=Nb_Jours_Sem)<date_min: # Si on a pas le delta de jour d'enregistrement
        print("Evolution sur une semaine:il manque malheuresement des valeurs pour afficher toute la plage")
        xmin = date_min
    else:
        xmin = xmax - relativedelta(days=Nb_Jours_Sem) # si on a plus que le delta de jour en enregistrement
                
    plt.xlim(xmin,xmax) # On "zoom"
    chemin="Graphs/%s_Sem.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe

    if xmax-relativedelta(days=Nb_Jours_Mois_Courant)<date_min: # Si on a pas le delta de jour d'enregistrement    print("il manque des valeurs pour afficher toute la plage")
        xmin = date_min
        print("Evolution sur un mois:il manque malheuresement des valeurs pour afficher toute la plage")
    else:
        xmin = xmax - relativedelta(days=Nb_Jours_Mois_Courant) # si on a plus que le delta de jour en enregistrement
                
    plt.xlim(xmin,xmax) # On "zoom"
    chemin="Graphs/%s_Mois.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe

    if xmax-relativedelta(days=Nb_Jours_Annee_Courant)<date_min: # Si on a pas le delta de jour d'enregistrement
        print("Evolution sur une année:il manque malheuresement des valeurs pour afficher toute la plage")
        xmin = date_min
    else:
        xmin = xmax - relativedelta(days=Nb_Jours_Annee_Courant) # si on a plus que le delta de jour en enregistrement
                
    plt.xlim(xmin,xmax) # On "zoom"
    chemin="Graphs/%s_Annee.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe
 
#
# Fin sous fonction de génération des graph PNG
#


while True:
  temp_press = sense.get_temperature_from_pressure()
  temp_press = round(temp_press, 2)
  
  temp_hum = sense.get_temperature_from_humidity()
  temp_hum = round(temp_hum,2)
  
  hum = sense.get_humidity()
  hum = round(hum,2)
  
  press = sense.get_pressure()
  press = round(press,2)
  
  date  = time.strftime("%D/%m/%Y")
  heure  = time.strftime("%X")
  min = int(time.strftime("%M"))
  
  # Remplissagge du fichier csv avec les variables
  
  if min_ref+Interval >= 60: #la variable "min" étant comprise entre 0 et 60 "min_ref ne doit pas dépasser 59
      min_ref = 00
          
  if min == min_ref+Interval:
      file = open(fname, "at") # Ouverture du csv
      wtr = csv.writer(file, delimiter=',') # création du writer
      
      concat = ["{0},{1},{2},{3},{4},{5}".format(date,heure,temp_press, temp_hum, hum, press)] # Création de la ligne concaténant toutes les variables qui sera écrite dans le CSV
      print("concat = %s" %concat) # On l'affiche #JustToCheck #AuCasOu

      wtr.writerows(i.strip().split(',') for i in concat)
      
      min_ref = int(time.strftime("%M"))    
  
  #Fin du remplissage
  if min_ref_2 + 30 >= 60: #la variable "min" étant comprise entre 0 et 60 "min_ref ne doit pas dépasser 59
      min_ref_2 = 00
  
  if min == min_ref_2 + 30:
      Generation_Graph(fname,'température 1','temperature_1') #Génération des courbes tepérature 1
      Generation_Graph(fname,'température 2','temperature_2') #Génération des courbes tepérature 2
      Generation_Graph(fname,'humidité','hum')                #Génération des courbes humidité
      Generation_Graph(fname,'pression','pression')           #Génération des courbes pression
      
      min_ref_2 = int(time.strftime("%M"))
  
  #print(time.strftime("%x %X"), "temperature via pression=%s°C" %temp_press, "temperature via hum=%s°C" %temp_hum, "humidité=%s%" %hum, "pression=%s%" %press)
  
  for event in sense.stick.get_events():
    
    # Check if the joystick was pressed
    if event.action == "pressed":
      
      # Check which direction
      if event.direction == "up":
        # Affichage de la température via capteur de pression «%s» format de chaine de caractère
        sense.set_pixels(temp_Unit) #Affichage de l'image "temp_Unit"
        time.sleep(0.7) # On attend
        sense.show_message("%s" %temp_press,0.1, text_colour=R,back_colour=N)  # Affichage de la valeur en défilant
        sense.clear() # Clear de la matrice led
        
      elif event.direction == "down":
        # Affichage de la température via capteur d'humidité «%s» format de chaine de caractère
        sense.set_pixels(temp_Unit)
        time.sleep(0.7)
        sense.show_message("%s" %temp_hum,0.1, text_colour=R,back_colour=N)  
        sense.clear()
        
      elif event.direction == "left": 
        # Affichage de la pression «%s» format de chaine de caractère
        sense.set_pixels(press_Unit)
        time.sleep(0.7)
        sense.show_message("%sh" %press,0.1, text_colour=B,back_colour=N)
        sense.clear()
        
      elif event.direction == "right":
        # Affichage de l'humidité «%s» format de chaine de caractère
        sense.set_pixels(Hum_Unit)
        time.sleep(0.7)
        sense.show_message("%s" %hum,0.1, text_colour=V,back_colour=N)
        sense.clear()
        
      elif event.direction == "middle":
        sense.set_pixels(middle_1) 
        time.sleep(0.3)
        sense.set_pixels(middle_2) 
        time.sleep(0.3)
        sense.set_pixels(middle_3)
        time.sleep(0.3)
        sense.set_pixels(middle_4) 
        time.sleep(0.3)
        sense.set_pixels(middle_3) 
        time.sleep(0.3)
        sense.set_pixels(middle_2) 
        time.sleep(0.3)
        sense.set_pixels(middle_1) 
        time.sleep(0.3)
        sense.clear()
        
        file.close() #Fermeture du  CSV
        sense.show_message("Saving CSV",0.1, text_colour=V,back_colour=N)
        
  file.close() #Fermeture du  CSV
        
        


