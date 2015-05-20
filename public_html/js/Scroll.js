/// <reference path="../../typings/jquery/jquery.d.ts"/>
$(document).ready(function() {
  
  $("#cloudicon").click(function scrolltofoot(){
    
      $("#footer").velocity("scroll", { 
      duration: 500,
      delay: 0,
      easing: "ease-in-out",
      mobileHA: false
      });
      
  });
  
   // bind click event to all internal page anchors
    $("a[href*=#]").bind("click", function(e) {
        // prevent default action and bubbling
        e.preventDefault();
        e.stopPropagation();
        // set target to anchor's "href" attribute
        var target = $(this).attr("href");
        // scroll to each target
        $(target).velocity("scroll", {
            duration: 500,
            offset: 40,
            easing: "ease-out"
        });
        
        $(this).addClass(".underline");
    });
  
});


