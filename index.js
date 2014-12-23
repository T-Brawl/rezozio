if (document.getElementById("message") != null) zone = document.getElementById("message");
cpt = document.getElementById("cpt");

function size() { 
	var longueur = 140 - zone.value.length;
	pere = cpt.parentNode;
	pere.removeChild(cpt);
	cpt = document.createElement('span');
	if (longueur == 0)	{cpt.style.fontWeight = "bolder";}
	if (longueur <= 20)	{cpt.style.color = "red";}
	if (20 < longueur && longueur <= 40) {cpt.style.color = "orange";}
	string = document.createTextNode(longueur.toString());
	pere.appendChild(cpt);
	cpt.appendChild(string);
} 

function send(e) {
	var keyCode = e.keyCode;
  	if (keyCode == 13) { envoyer.click(); }
}

if (document.getElementById("message") != null) zone.addEventListener("keyup",size,false); 
if (document.getElementById("message") != null) zone.addEventListener("keydown",send,false);

