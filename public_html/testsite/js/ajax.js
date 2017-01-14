/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to validate and process the email submssion field
/*================================================================================================================*/
/*================================================================================================================*/

 $(function () {

    $(".formbutton").click(function(e) {
        e.preventDefault();

      // Variables 
      var emailfield = document.getElementById("emailAddress");
      var email = document.getElementById("emailAddress").value;
	  var status = document.getElementById("success");
	  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

      // Validate for a blank email address and show warning if blank.
	  if (!email){
	  	status.innerHTML = "Please enter an email address";
		status.style.opacity = 1;
		status.style.color = "#ff6700";
	      //status.className = status.className + " shake";
		$("#signupform").velocity("callout.shake");
		$("#success").velocity("callout.shake");
	  	return false;
	  }
      
      // Validate for a proper email address and show warning if not.
	  if (email.match(mailformat)){
	  }
	  else {
	      status.innerHTML = "Please enter a valid email address.";
	      status.style.opacity = 1;
	      status.style.color = "#ff6700";
	      //status.style.webkitAnimationName = 'thumb';
	      //status.className = status.className + " shake";
	      $("#signupform").velocity("callout.shake");
		  $("#success").velocity("callout.shake");
	      return false;
	  }

      // ajax request to post email address to the database using DBCon PHP file.
	  $.ajax({
		type: "POST",
		url: "./php/DBCon.php",
		data: {postemail:email},
		success: function() {
			console.log('success');
			status.innerHTML = "Thanks for your support, we'll let you know how we're getting on!";
			status.style.opacity = 1;
			//emailfield.value = " ";
		},
		error: function() {
			console.log('error')
			status.innerHTML = "Sorry, we couldn't save your email address at this time.";
			status.style.opacity = 1;
			status.style.color = "#ff6700";
		}
	  });
	
   });
    return false;
});