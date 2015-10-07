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
			
			if($(password).val() != $(confirmPassword).val()){
				
				status.innerHTML = "Your passwords don't match";
				status.style.opacity = 1;
				status.style.color = "#ff6700";
				$("#loginForm").velocity("callout.shake");
		  		$("#success").velocity("callout.shake");
				  
				return false;
			}
			else{
				form.submit();
				return true;
			}
	});
});