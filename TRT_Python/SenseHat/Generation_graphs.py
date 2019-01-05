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

    df = pd.read_csv(fname,sep=',',parse_dates={'datetime':['date','heure']}, header=0, names=['date','heure','température 1','température 2','humidité','pression', 'température exterieure', 'humidité exterieure', 'température chambre', 'humidité chambre']) #Ecriture de la 1ère ligne (titre des colonnes

    df['datetime'] = df['datetime'].apply(lambda x: x.strptime(str(x), '%Y-%d-%m %H:%M:%S'))
    #df['datetime'] = df['datetime'].apply(lambda x: x.strftime('%d-%m-%Y %H:%M:%S'))
    
    print(df)
    
    x_min, x_max = plt.xlim() #initialisation des variables x_min, x_max (valeur min/max de l'axe "X") avec la valeur actuel

    row_max,column = df.shape #obtention du nombre de ligne et de colonne du csv
    row_max = row_max-1 #N° de la ligne max du csv

    x_max=df['datetime'].iloc[row_max] # Valeur de la dernière ligne de la colonne 'date'
    #x_max = datetime.strptime(x_max,'%d-%m-%Y %H:%M:%S') # conversion en date
    x_max = x_max.to_pydatetime()
    #x_max = x_max.datetime()
    print (x_max)

    date_min = df['datetime'].iloc[0] # Valeur de la première ligne de la colonne date
    #date_min = datetime.strptime(date_min,'%d-%m-%Y %H:%M:%S') # conversion en date
    date_min = date_min.to_pydatetime()
    
    #
    ## Génération des graphs
    #
    plt.grid()
    plt.xlabel('date')
    plt.ylabel(Axe_Y)
    plt.tight_layout()

    chemin="/home/pi/Desktop/SenseHat/Graphs/%s.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe

    if x_max - timedelta(days = 8)<date_min: # Si on a pas le delta de jour d'enregistrement
        #print("Evolution sur une semaine:il manque malheuresement des valeurs pour afficher toute la plage")
        x_min = date_min
    else:
        x_min = x_max -timedelta(days=8) # si on a plus que le delta de jour en enregistrement
         
    print ("x_max= %s"%x_max)
    print ("type x_max= %s"%type(x_max))
    print ("x_min= %s"%x_min)
    print ("type x_min= %s"%type(x_min))


    fig_1 = df.plot(x='datetime',y=Axe_Y, figsize = (20, 12))

                     
    plt.xlim((x_min,x_max)) # On "zoom"
    plt.xticks(rotation=45)
    chemin="/home/pi/Desktop/SenseHat/Graphs/essais/%s_Sem.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe

    if x_max-timedelta(days=31)<date_min: # Si on a pas le delta de jour d'enregistrement    print("il manque des valeurs pour afficher toute la plage")
        x_min = date_min
        #print("Evolution sur un mois:il manque malheuresement des valeurs pour afficher toute la plage")
    else:
        x_min = x_max - timedelta(days=31) # si on a plus que le delta de jour en enregistrement
                
    plt.xlim(x_min,x_max) # On "zoom"
    chemin="/home/pi/Desktop/SenseHat/Graphs/essais/%s_Mois.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe



    if x_max-timedelta(days=366)<date_min: # Si on a pas le delta de jour d'enregistrement
        #print("Evolution sur une année:il manque malheuresement des valeurs pour afficher toute la plage")
        x_min = date_min
    else:
        x_min = x_max - timedelta(days=366) # si on a plus que le delta de jour en enregistrement
                
    plt.xlim(x_min,x_max) # On "zoom"
    chemin="/home/pi/Desktop/SenseHat/Graphs/essais/%s_Annee.png"%Prefix
    plt.savefig(chemin)  # enregistrement de la courbe
    
   
    print("Génération %s OK"%Axe_Y)

Generation_Graph(fname,'température 1','temperature_1') #Génération des courbes tepérature 1
##Generation_Graph(fname,'humidité','hum')                #Génération des courbes humidité
##Generation_Graph(fname,'température exterieure','temp_ext')           #Génération des courbes pression
##Generation_Graph(fname,'humidité exterieure','hum_ext')           #Génération des courbes pression
##Generation_Graph(fname,'température chambre','temp_chambre')           #Génération des courbes pression
##Generation_Graph(fname,'humidité chambre','hum_chambre')           #Génération des courbes pression
