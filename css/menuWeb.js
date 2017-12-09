$(document).ready(main);


var cont=1;

function mostrarMenu(){
	"use strict";
	if(cont===1){
		document.getElementById("nav").style.display = "none";
			cont=0;
		}else{
			cont=1;
			document.getElementById("nav").style.display = "block";
		}
}