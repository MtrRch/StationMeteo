#!/bin/bash

echo "Hum_ext" > /home/pi/Desktop/SenseHat/Capteur_distant.txt

result1=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=1" | jq -r .result[]."Data" | cut -d' ' -f3  >> /home/pi/Desktop/SenseHat/Capteur_distant.txt)


echo "Temp_ext" >> /home/pi/Desktop/SenseHat/Capteur_distant.txt

result2=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=1" | jq -r .result[]."Data" | cut -d' ' -f1 >> /home/pi/Desktop/SenseHat/Capteur_distant.txt)


echo "Hum_chambre" >> /home/pi/Desktop/SenseHat/Capteur_distant.txt

result3=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=9" | jq -r .result[]."Data" | cut -d' ' -f3  >> /home/pi/Desktop/SenseHat/Capteur_distant.txt)


echo "Temp_chambre" >> /home/pi/Desktop/SenseHat/Capteur_distant.txt

result4=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=9" | jq -r .result[]."Data" | cut -d' ' -f1 >> /home/pi/Desktop/SenseHat/Capteur_distant.txt)



echo "Hum_Salon" >> /home/pi/Desktop/SenseHat/Capteur_distant.txt

result3=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=9" | jq -r .result[]."Data" | cut -d' ' -f3  >> /home/pi/Desktop/SenseHat/Capteur_distant.txt)


echo "Temp_Salon" >> /home/pi/Desktop/SenseHat/Capteur_distant.txt

result4=$(curl -s "http://localhost:8080/json.htm?type=devices&rid=9" | jq -r .result[]."Data" | cut -d' ' -f1 >> /home/pi/Desktop/SenseHat/Capteur_distant.txt)


echo "Execution OK" 

