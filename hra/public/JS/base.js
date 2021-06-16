function openNav() {
	
	document.getElementById("mySidenav").style.display = "block";
  	document.getElementById("openNav").style.display = 'none';

  	document.getElementById("myOverlay").style.display = "block";

}

function closeNav() {
	
	document.getElementById("mySidenav").style.display = "none";
  	document.getElementById("openNav").style.display = 'block';

  	document.getElementById("myOverlay").style.display = "none";

}	

//---------------Ancienne NavBar---------------//
//$(document).ready(function(){
//
//	$('.navbar').hide();
//
//  $(function () {
//    $(window).scroll(function () {
//
//      if ($(this).scrollTop() > 140) {
//        $('.navbar').fadeIn();
//      } else {
//        $('.navbar').fadeOut();
//      }
//    });
//  });
//});
//---------------------------------------------//