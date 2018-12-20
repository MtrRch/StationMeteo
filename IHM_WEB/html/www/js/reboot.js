
function reboot()
{
	var r = confirm("Voulez-vous vraiment redémarrer la station?");
	if (r == true) {
		var request = new XMLHttpRequest();
		request.open( "GET" , "reboot.php");
		request.send(null);
	} else {
	} 
}

/*function reboot()
{
	var r = confirm("Voulez-vous vraiment éteindre la station?");
	if (r == true) {
		var request = new XMLHttpRequest();
		request.open( "GET" , "shutdown.php");
		request.send(null);
	} else {
	} 
}*/