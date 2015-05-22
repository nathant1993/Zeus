/// <reference path="../js/jquery.d.ts"/>
/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to scroll up and down to different divs on the page
/*================================================================================================================*/
/*================================================================================================================*/

$(document).ready(function() {
  
  var lastlink;
  
  //Testing scrolling
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
        //check if the last link is null - if it isn't remove the underline class 
        //from the last link before it's applied to the next link unless navigating to the top of the page
        if (!lastlink && target == "#hero"){}
        else {
            $(lastlink).removeClass("underline"); 
           }
        // scroll to each target
        $(target).velocity("scroll", {
            duration: 500,
            offset: 0,
            easing: "ease-out"
        });
        //Add the css class underline to the most recently 
        //navigated to link unless navigating to the top of the page
        if (target != "#hero") {
          $(this).addClass("underline");
          lastlink = $(this);
        }   
        
    });
  
});