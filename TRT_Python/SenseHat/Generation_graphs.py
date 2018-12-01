import pandas as pd
import datetime as dt
import time
import calendar
import csv
import matplotlib
import matplotlib.pyplot as plt

from dateutil.relativedelta import relativedelta
from datetime import datetime,timedelta

fname = "/home/pi/Desktop/SenseHat/export_donnees_SenseHat.csv" #Nom du fichier CSV dans lequel lire les valeurs

def Generation_Graph(fname,Axe_Y,Prefix):
    
    annee_courant = int(time.strftime("%Y"))
    mois_courant = int(time.strftime("%m"))
    semaine_courant  = int(time.strftime("%W"))
    Nb_heures_Jour = 1 # 1 journée
    Nb_Jours_Sem = 7 # Semaine = 7 jours
    Nb_Jours_Mois_Courant = calendar.monthrange(int(annee_courant),int(mois_courant))[1] #obtention du nombre de jour dans un mois
    Nb_Jours_Annee_Courant = dt.datetime(annee_courant,12,31)- dt.datetime(annee_courant,1,1) # Nombre de jour dans l'année courante
    Nb_Jours_Annee_Courant = Nb_Jours_Annee_Courant/timedelta(days=1)

    df = pd.read_csv(fname,sep=',',parse_dates=['date','heure'], header=0, names=['date','heure','température 1','température 2','humidité','pression', 'température exterieure', 'humidité exterieure', 'température chambre', 'humidité chambre']) #Ecriture de la 1ère ligne (titre des colonnes
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

    if xmax-relativedelta(days=Nb_heures_Jour)<date_min: # Si on a pas le delta de jour d'enregistrement
        print("Evolution sur un jour: il manque malheuresement des valeurs pour afficher toute la plage")
        xmin = date_min
    else:
        xmin = xmax - relativedelta(days=Nb_heures_Jour) # si on a plus que le delta de jour en enregistrement

    
    plt.xlim(xmin,xmax) # On "zoom"
    chemin="/home/pi/Desktop/SenseHat/Graphs/%s_Jours.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe

    fig_1 = df.plot(x='date',y=Axe_Y, figsize = (10, 5))

    if xmax-relativedelta(days=Nb_Jours_Sem)<date_min: # Si on a pas le delta de jour d'enregistrement
        print("Evolution sur une semaine:il manque malheuresement des valeurs pour afficher toute la plage")
        xmin = date_min
    else:
        xmin = xmax - relativedelta(days=Nb_Jours_Sem) # si on a plus que le delta de jour en enregistrement
                
    plt.xlim(xmin,xmax) # On "zoom"
    chemin="/home/pi/Desktop/SenseHat/Graphs/%s_Sem.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe

    if xmax-relativedelta(days=Nb_Jours_Mois_Courant)<date_min: # Si on a pas le delta de jour d'enregistrement    print("il manque des valeurs pour afficher toute la plage")
        xmin = date_min
        print("Evolution sur un mois:il manque malheuresement des valeurs pour afficher toute la plage")
    else:
        xmin = xmax - relativedelta(days=Nb_Jours_Mois_Courant) # si on a plus que le delta de jour en enregistrement
                
    plt.xlim(xmin,xmax) # On "zoom"
    chemin="/home/pi/Desktop/SenseHat/Graphs/%s_Mois.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe

    if xmax-relativedelta(days=Nb_Jours_Annee_Courant)<date_min: # Si on a pas le delta de jour d'enregistrement
        print("Evolution sur une année:il manque malheuresement des valeurs pour afficher toute la plage")
        xmin = date_min
    else:
        xmin = xmax - relativedelta(days=Nb_Jours_Annee_Courant) # si on a plus que le delta de jour en enregistrement
                
    plt.xlim(xmin,xmax) # On "zoom"
    chemin="/home/pi/Desktop/SenseHat/Graphs/%s_Annee.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe

Generation_Graph(fname,'température 1','temperature_1') #Génération des courbes tepérature 1
Generation_Graph(fname,'température 2','temperature_2') #Génération des courbes tepérature 2
Generation_Graph(fname,'humidité','hum')                #Génération des courbes humidité
Generation_Graph(fname,'pression','pression')           #Génération des courbes pression
Generation_Graph(fname,'température exterieure','temp_ext')           #Génération des courbes pression
Generation_Graph(fname,'humidité exterieure','hum_ext')           #Génération des courbes pression
Generation_Graph(fname,'température chambre','temp_chambre')           #Génération des courbes pression
Generation_Graph(fname,'humidité chambre','hum_chambre')           #Génération des courbes pression
