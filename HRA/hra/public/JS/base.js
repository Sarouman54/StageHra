function openNav() {
	document.getElementById("mySidenav").style.width = "15%";
	
	document.getElementById("footerLeft").style.width = "26%";
	document.getElementById("footerCenter").style.width = "26%";
	document.getElementById("footerRight").style.width = "26%";
	
	document.getElementById("footerLeft").style.marginLeft = "12%";
	document.getElementById("footerCenter").style.marginLeft = "4%";
	document.getElementById("footerRight").style.marginLeft = "4%";

}

function closeNav() {
	document.getElementById("mySidenav").style.width = "0";
	
	document.getElementById("footerLeft").style.width = "33%";
	document.getElementById("footerCenter").style.width = "33%";
	document.getElementById("footerRight").style.width = "33%";
	
	document.getElementById("footerLeft").style.marginLeft = "0%";
	document.getElementById("footerCenter").style.marginLeft = "0%";
	document.getElementById("footerRight").style.marginLeft = "0%";
}	