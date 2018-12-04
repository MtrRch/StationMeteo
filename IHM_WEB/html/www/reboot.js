
function reboot()
{
	var r = confirm("Voulez-vous vraiment redémarrer la station?");
	if (r == true) {
		alert("la station va redémarrer");
		var request = new XMLHttpRequest();
		request.open( "GET" , "reboot.php");
		request.send(null);
	} else {
	} 
}

function shutdown()
{
	var r2 = confirm("Voulez-vous vraiment éteindre la station?");
	if (r2 == true) {
		alert("la station va s'éteindre");
		var request = new XMLHttpRequest();
		request.open( "GET" , "shutdown.php");
		request.send(null);
	} else {
	} 
}