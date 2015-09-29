/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to process the update of any PBI displayed in the PBI form
/*================================================================================================================*/
/*================================================================================================================*/

 $(function () {
	 
	 //Listen for the update button in the Pbi filter form to be clicked
     $("#showCreatePBIForm").click(function(e) {
        e.preventDefault();
		
		//Show the pbiDetails form and show the create button
		$('#pbiDetails').velocity({opacity:1}, {duration:200});
		$('#createPBI').show();
		$('#createPBI').css("visibility","visible");
	 	$('#createPBI').velocity({opacity:1}, {duration:0});
		
		//Make sure the update and delete button are not shown  
		$('#pbiDetailsButton').hide();
		$('#pbiDetailsButton').css("visibility","hidden");
		$('#pbiDetailsButton').velocity({opacity:0}, {duration:0});
		$('#deletePbiButton').hide();
		$('#deletePbiButton').css("visibility","hidden");
		$('#deletePbiButton').velocity({opacity:0}, {duration:0}); 
		
		//Clear the pbi details form so that there is a fresh form to enter a new pbi
		document.getElementById("pbiID").value = "";
		document.getElementById("pbiTitle").value = "";
		document.getElementById("pbiDescription").value = "";
		document.getElementById("pbiEffort").value = "";
		document.getElementById("pbiDetailPriority").value = "";
		document.getElementById("pbiDetailState").value = "";
		document.getElementById("pbiIteration").value = "";
		document.getElementById("pbiProject").value = "";
		
	 });
	
	$("#createPBI").click(function(e) {	
		e.preventDefault() 
		//Variables 
		var updateID = document.getElementById("pbiID").value;
		var updateTitle = document.getElementById("pbiTitle").value;
		var updateDesc = document.getElementById("pbiDescription").value;
		var updateEffort = document.getElementById("pbiEffort").value;
		var updatePriority = document.getElementById("pbiDetailPriority").value;
		var updateState = document.getElementById("pbiDetailState").value;
		var updateIteration = document.getElementById("pbiIteration").value;
		var updateProject = document.getElementById("pbiProject").value;
		var status = document.getElementById("UpdateStatus");

		//Check if the Title field is empty before submitting - if it is then do not submit the data
		//And provide a suitable error message
		if (updateTitle == null || updateTitle == ""){
			$("#greyOut").velocity("transition.fadeIn")
			.velocity({opacity:0.95}, {duration:2000})
			.velocity("transition.fadeOut");
			
			$("#popupContact").html("You can't create a PBI without a Title!")
			
			$("#popupContact").velocity("transition.bounceUpIn")
			.velocity({opacity:1}, {duration:2000})
			.velocity("transition.fadeOut");
			return false;
		}
		//If the ID isn't Null then submit the update
	  	else{
		//Ajax request to update the current PBI with whatever new value has been entered in to the form
		$.ajax({
			type: "POST",
			url: "../php/CreatePBI.php",
			data: {
				postedID:updateID,
				postedTitle:updateTitle,
				postedDesc:updateDesc,
				postedEffort:updateEffort,
				postedPriority:updatePriority,
				postedState:updateState,
				postedIteration:updateIteration,
				postedProject:updateProject
			},
			success: function(results) {
				//style a status div to provide feedback on how the update went
				// status.innerHTML = "Pbi successfully created!";
				// $("#UpdateStatus")
				// 	.velocity({opacity:1}, {duration:200})
				// 	.velocity({opacity:1}, {duration:3000})
				// 	.velocity({opacity:0}, {duration:1000});
				
				e.preventDefault();
				$("#greyOut").velocity("transition.fadeIn")
				.velocity({opacity:0.95}, {duration:2000})
				.velocity("transition.fadeOut");
				
				$("#popupContact").html("Your PBI was successfully created!")
				
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