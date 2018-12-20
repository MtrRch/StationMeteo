$(document).ready(function() {
   horloge();
   ts3();
   xplanet();
   ifstat();
   meteo();
   vpn();
   ping();
});

/* horloge */

var horloge_timeout;

function horloge()
{
  dows  = ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"];
  mois  = ["janv", "f&eacute;v", "mars", "avril", "mai", "juin", "juillet", "ao&ucirc;t", "sept", "oct", "nov", "d&eacute;c"];

  now          = new Date;
  heure        = now.getHours();
  min          = now.getMinutes();
  sec          = now.getSeconds();
  jour_semaine = dows[now.getDay()];
  jour         = now.getDate();
  mois         = mois[now.getMonth()];
  annee        = now.getFullYear();

  if (sec < 10){sec0 = "0";}else{sec0 = "";}
  if (min < 10){min0 = "0";}else{min0 = "";}
  if (heure < 10){heure0 = "0";}else{heure0 = "";}

  horloge_heure   = heure + ":" + min0 + min;
  horloge_date    = "<h5 class='horloge_grey'>" + jour_semaine + "</h5> " + jour + " " + mois + " <h5 class='horloge_grey'>" + annee + "</h5>";
  horloge_content = "<h5 class='horloge_heure'>" + horloge_heure + "</h5><div class='horloge_date'>" + horloge_date + "</div>";

  $("#horloge").html(horloge_content);

  horloge_timeout = setTimeout("horloge()", 1000);
}

/* TS3 */

var ts3_timeout;

function ts3 ()
{
  $.ajax({
    async : false,
    type: "GET",
    url: "./ajax.php",
    data: "block=ts3",
    success: function(html){
      $("#ts3").html(html);
    }
  });

  ts3_timeout = setTimeout("ts3()", 10000);
}
 