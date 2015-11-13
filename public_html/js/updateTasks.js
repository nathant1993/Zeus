/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to process the update of any PBI displayed in the PBI form
/*================================================================================================================*/
/*================================================================================================================*/

 $(function () {
	 
	 //Listen for the update button in the Pbi form to be clicked
     $("#pbiDetailsButton").click(function(e) {
         e.preventDefault();

     // Variables 
      	var updateID = document.getElementById("taskID").value;
		var updateTitle = document.getElementById("taskTitle").value;
		var updatePbiTitle = document.getElementById("pbiTitle").value;
		var updateAssignee = document.getElementById("assignee").value;
		var updateDesc = document.getElementById("taskDescription").value;
		var updateEstimatedTime = document.getElementById("estimatedTime").value;
		var updateTimeSpent = document.getElementById("timeSpent").value;
		var updateState = document.getElementById("taskDetailState").value;
		var updateIteration = document.getElementById("taskIteration").value;
		var updateProject = document.getElementById("taskProject").value;
		
	  //Check if the ID field is empty before submitting - if it is then do not submit the data
	  //And provide a suitable error message
		if (updateID == null || updateID == ""){
		  	$("#greyOut").velocity("transition.fadeIn")
			.velocity({opacity:0.9});
			$("#popupContact").velocity("transition.bounceDownIn")
			.velocity({opacity:1});
			$("#popupContact").prepend('<img id="msgImg" src="../images/cross.svg" /> <h1 id="msgH1">Sorry we could not update your PBI.</h1> <br> <a href="#" id="msgClose">OK</a>');
			
			//Close popup div and remove elements from the div so they don't stack up on each other
			$("#msgClose").click(function(e) {
				e.preventDefault();
				$("#popupContact").velocity("transition.bounceUpOut");
				$("#greyOut").velocity("transition.fadeOut",{delay:200});
				$("#msgImg").remove();
				$("#msgH1").remove();
				$("#msgClose").remove();			
			});
		  return false;
	  	}
	  //If the ID isn't Null then submit the update
	  else{  
			$("#greyOut").velocity("transition.fadeIn")
			.velocity({opacity:0.9});
			$("#popupContact").velocity("transition.bounceDownIn")
			.velocity({opacity:1});
			$("#popupContact").prepend('<img id="msgImg" src="../images/query.svg" /> <h1 id="msgH1">Are you sure you want to update this PBI?</h1> <br> <a href="#" id="confirmButton">Yes</a> <a href="#" id="msgClose">No</a>');
			
			$("#msgClose").click(function(e) {
				e.preventDefault();
				$("#popupContact").velocity("transition.bounceUpOut");
				$("#greyOut").velocity("transition.fadeOut",{delay:200});
				$("#msgImg").remove();
				$("#msgH1").remove();
				$("#msgClose").remove();
				$("#confirmButton").remove();			
			});
				
		  	$("#confirmButton").click(function(e) {
				e.preventDefault();
				$("#msgImg").remove();
				$("#msgH1").remove();
				$("#msgClose").remove();
				$("#confirmButton").remove();
				//Ajax request to update the current PBI with whatever new value has been entered in to the form
				$.ajax({
					type: "POST",
					url: "../php/UpdatePBI.php",
					data: {
						postedID:updateID,
						postedTitle:updateTitle,
						postedPbiTitle:updatePbiTitle,
						postedAssignee:updateAssignee,
						postedDesc:updateDesc,
						postedEstimatedTime:updateEstimatedTime,
						postedTimeSpent:updateTimeSpent,
						postedState:updateState,
						postedIteration:updateIteration,
						postedProject:updateProject
					},
					success: function(results) {
						console.log(results);
						//style and add content to a status div that pops up to provide feedback on how the update went
						$("#greyOut").velocity("transition.fadeIn")
						.velocity({opacity:0.9});
						$("#popupContact").velocity("transition.bounceDownIn")
						.velocity({opacity:1});
						$("#popupContact").prepend('<img id="msgImg" src="../images/tick.svg" /> <h1 id="msgH1">Your PBI was successfully updated!</h1> <br> <a href="#" id="msgClose">OK</a>');
						
						//Close popup div and remove elements from the div so they don't stack up on each other
						$("#msgClose").click(function(e) {
							e.preventDefault();
							$("#popupContact").velocity("transition.bounceUpOut");
							$("#greyOut").velocity("transition.fadeOut",{delay:200});
							$("#msgImg").remove();
							$("#msgH1").remove();
							$("#msgClose").remove();			
						});
					},
					error: function(results) {
						console.log(results);
						//style and add content to a status div that pops up to provide feedback on how the update went
						$("#greyOut").velocity("transition.fadeIn")
						.velocity({opacity:0.9});
						$("#popupContact").velocity("transition.bounceDownIn")
						.velocity({opacity:1});
						$("#popupContact").prepend('<img id="msgImg" src="../images/cross.svg" /> <h1 id="msgH1">Sorry we could not update your PBI.</h1> <br> <a href="#" id="msgClose">OK</a>');
						
						//Close popup div and remove elements from the div so they don't stack up on each other$("#msgClose").click(function(e) {
						$("#msgClose").click(function(e) {
							e.preventDefault();
							$("#popupContact").velocity("transition.bounceUpOut");
							$("#greyOut").velocity("transition.fadeOut",{delay:200});
							$("#msgImg").remove();
							$("#msgH1").remove();
							$("#msgClose").remove();			
						});
					}
				});
			});
	  	}
	});
	return false;
 });