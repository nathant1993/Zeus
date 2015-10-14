/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to validate password reset fields
/*================================================================================================================*/
/*================================================================================================================*/
$(function () {
	$("#resetPasswordButton").click(function(e) {	
			e.preventDefault() 
			
			var form = document.getElementById('loginForm');
			var status = document.getElementById("success");
			
			//check if the password and confirm password boxes contain the same thing
			if($(password).val() != $(confirmPassword).val()){
				
				status.innerHTML = "Your passwords don't match";
				status.style.opacity = 1;
				status.style.color = "#ff6700";
				$("#loginForm").velocity("callout.shake");
		  		$("#success").velocity("callout.shake");
				  
				return false;
			}
			//check if passwords contain a number
			else if(!$(password).val().match(/([\d])/)){
				status.innerHTML = "Your password needs to contain a number"
				status.style.opacity = 1;
				status.style.color = "#ff6700";
				$("#loginForm").velocity("callout.shake");
		  		$("#success").velocity("callout.shake");
				  
				return false;
			}
			//check if passwords contain a lower case letter
			else if(!$(password).val().match(/([a-z])/)){
				status.innerHTML = "Your password needs to contain a lower case letter"
				status.style.opacity = 1;
				status.style.color = "#ff6700";
				$("#loginForm").velocity("callout.shake");
		  		$("#success").velocity("callout.shake");
				  
				return false;
			}
			//check if passwords contain an uppercase letter
			else if(!$(password).val().match(/([A-Z])/)){
				status.innerHTML = "Your password needs to contain an upper case letter"
				status.style.opacity = 1;
				status.style.color = "#ff6700";
				$("#loginForm").velocity("callout.shake");
		  		$("#success").velocity("callout.shake");
				  
				return false;
			}
			//check if a password is it characters long or not
			else if ($(password).val().length < 8) {
				status.innerHTML = "Your password needs to contain 8 characters or more";
				status.style.opacity = 1;
				status.style.color = "#ff6700";
				$("#loginForm").velocity("callout.shake");
		  		$("#success").velocity("callout.shake");
				  
				return false;
			} 
			//If the passwords pass these checks then submit the password submit form
			else{
				form.submit();
				return true;
			}
	});
});