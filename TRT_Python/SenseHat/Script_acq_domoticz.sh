#!/bin/bash

echo "Hum_ext" > Capteur_distant.txt

result1=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=1" | jq -r .result[]."Data" | cut -d' ' -f3  >> Capteur_distant.txt)

echo "Temp_ext" >> Capteur_distant.txt

result2=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=1" | jq -r .result[]."Data" | cut -d' ' -f1 >> Capteur_distant.txt)


echo "Hum_chambre" >> Capteur_distant.txt

result3=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=9" | jq -r .result[]."Data" | cut -d' ' -f3  >> Capteur_distant.txt)

echo "Temp_chambre" >> Capteur_distant.txt

result4=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=9" | jq -r .result[]."Data" | cut -d' ' -f1 >> Capteur_distant.txt)



echo "Hum_Salon" >> Capteur_distant.txt

result3=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=9" | jq -r .result[]."Data" | cut -d' ' -f3  >> Capteur_distant.txt)

echo "Temp_Salon" >> Capteur_distant.txt

result4=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=9" | jq -r .result[]."Data" | cut -d' ' -f1 >> Capteur_distant.txt)


echo "Execution OK" 

