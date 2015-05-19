/// <reference path="../../typings/jquery/jquery.d.ts"/>
$(document).ready(function() {
  $("#cloudicon").click(function scrolltofoot(){
      $("#footer").velocity("scroll", { 
      duration: 500,
      delay: 0,
      easing: "ease-out",
      mobileHA: false
      });
  });
});


