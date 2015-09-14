/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to process the update of any PBI displayed in the PBI form
/*================================================================================================================*/
/*================================================================================================================*/

 $(function () {
	 
	 //Listen for the update button in the Pbi form to be clicked
     $("#pbiDetailsButton").click(function(e) {
         e.preventDefault();

      // // Variables 
      var updateID = document.getElementById("pbiID").value;
	  var updateTitle = document.getElementById("pbiTitle").value;
	  var updateDesc = document.getElementById("pbiDescription").value;
	  var updateEffort = document.getElementById("pbiEffort").value;
	  var updatePriority = document.getElementById("pbiDetailPriority").value;
	  var updateState = document.getElementById("pbiDetailState").value;
	  var updateIteration = document.getElementById("pbiIteration").value;
	  var updateProject = document.getElementById("pbiProject").value;
	  var status = document.getElementById("UpdateStatus");
	  
	  //Check if the ID field is empty before submitting - if it is then do not submit the data
	  //And provide a suitable error message
	  if (updateID == null || updateID == ""){
		  status.innerHTML = "Could not update this PBI, the ID field is empty.";
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
			url: "../php/UpdatePBI.php",
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
				status.innerHTML = "Pbi successfully updated!";
				$("#UpdateStatus")
					.velocity({opacity:1}, {duration:200})
					.velocity({opacity:1}, {duration:3000})
					.velocity({opacity:0}, {duration:1000});
			},
			error: function(results) {
				//style a status div to provide feedback on how the update went	
				status.innerHTML = "Pbi update was unsuccessful.";
				$("#UpdateStatus")
					.velocity({opacity:1}, {duration:200})
					.velocity("callout.shake")
					.velocity({opacity:1}, {duration:3000})
					.velocity({opacity:0}, {duration:1000});
				$("UpdateStatus").velocity("callout.shake")
			}
		});
	  }
	});
	return false;
 });