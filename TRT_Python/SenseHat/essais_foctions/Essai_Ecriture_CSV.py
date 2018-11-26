import csv
import time
from datetime import datetime
 
fname = "essai.csv" #Nom du fichier "*.csv" dans lequel écrire

file = open(fname, "wt") # Ouverture du csv
wtr = csv.writer(file, delimiter=',') # création du writer

wtr.writerow(('date','heure','température', 'humidité', 'pression'))

temp = 24
hum = 40
press=1000

while temp < 34:
    date  = time.strftime("%x")
    heure  = time.strftime("%X")
    temp = temp + 1
    hum = hum + 4
    press = press + 15
    
    print("%s" %date, "%s" %heure, "%s" %temp, "%s" %hum, "%s" %press )
    concat = ["{0},{1},{2},{3},{4}".format(date,heure,temp,hum,press)]
    print("concat = %s" %concat)
    
    #wtr.writerow(concat)
    wtr.writerows(i.strip().split(',') for i in concat)
 
file.close()
