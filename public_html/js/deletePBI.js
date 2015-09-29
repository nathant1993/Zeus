/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to process the update of any PBI displayed in the PBI form
/*================================================================================================================*/
/*================================================================================================================*/

 $(function () {
	 
	$("#deletePbiButton").click(function(e) {	
		e.preventDefault() 
		//Variables 
		var updateID = document.getElementById("pbiID").value;
		var status = document.getElementById("UpdateStatus");
		
		//Check if the ID field is empty before submitting - if it is then do not submit the data
		//And provide a suitable error message
		if (updateID == null || updateID == ""){
			status.innerHTML = "We could not delete this PBI, the ID field is empty.";
			$("#UpdateStatus")
				.velocity({opacity:1}, {duration:200})
				.velocity("callout.shake")
				.velocity({opacity:1}, {duration:3000})
				.velocity({opacity:0}, {duration:1000});
			$("UpdateStatus").velocity("callout.shake")
			return false;
		}
		//If the ID isn't Null then submit the update
	  	else{
		//Ajax request to update the current PBI with whatever new value has been entered in to the form
		$.ajax({
			type: "POST",
			url: "../php/DeletePBI.php",
			data: {
				postedID:updateID,
			},
			success: function(results) {
				//style a status div to provide feedback on how the update went
				$("#greyOut").velocity("transition.fadeIn")
				.velocity({opacity:0.95}, {duration:2000})
				.velocity("transition.fadeOut");
				
				$("#popupContact").html("Your PBI was successfully deleted!")
				
				$("#popupContact").velocity("transition.bounceUpIn")
				.velocity({opacity:1}, {duration:2000})
				.velocity("transition.fadeOut");
			},
			error: function(results) {
				//style a status div to provide feedback on how the update went	
				$("#greyOut").velocity("transition.fadeIn")
				.velocity({opacity:0.95}, {duration:2000})
				.velocity("transition.fadeOut");
				
				$("#popupContact").html("Sorry we couldn't create your PBI.")
				
				$("#popupContact").velocity("transition.bounceUpIn")
				.velocity({opacity:1}, {duration:2000})
				.velocity("transition.fadeOut");
			}
		});
	  }
	});
	return false;
 });