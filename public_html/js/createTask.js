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
		document.getElementById("taskID").value = "";
		document.getElementById("taskTitle").value = "";
		document.getElementById("pbiTitle").value = "";
		document.getElementById("assignee").value = "";
		document.getElementById("taskDescription").value = "";
		document.getElementById("estimatedTime").value = "";
		document.getElementById("timeSpent").value = "";
		document.getElementById("taskDetailState").value = "";
		document.getElementById("taskIteration").value = "";
		document.getElementById("taskProject").value = "";
	 });
	
	$("#createPBI").click(function(e) {	
		e.preventDefault() 
		//Variables 
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
		var status = document.getElementById("UpdateStatus");

		//Check if the Title field is empty before submitting - if it is then do not submit the data
		//And provide a suitable error message
		if (updateTitle == null || updateTitle == ""){
			$("#greyOut").velocity("transition.fadeIn")
			.velocity({opacity:0.9});
			$("#popupContact").velocity("transition.bounceDownIn")
			.velocity({opacity:1});
			$("#popupContact").prepend('<img id="msgImg" src="../images/cross.svg" /> <h1 id="msgH1">Your task needs a Title!</h1> <br> <a href="#" id="msgClose">OK</a>');
			
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
		//Ajax request to update the current PBI with whatever new value has been entered in to the form
		$.ajax({
			type: "POST",
			url: "../php/CreateTask.php",
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
				//style and add content to a status div that pops up to provide feedback on how the update went
				$("#greyOut").velocity("transition.fadeIn")
				.velocity({opacity:0.9});
				$("#popupContact").velocity("transition.bounceDownIn")
				.velocity({opacity:1});
				$("#popupContact").prepend('<img id="msgImg" src="../images/tick.svg" /> <h1 id="msgH1">Your task was successfully created!</h1> <br> <a href="#" id="msgClose">OK</a>');
				
				//Close popup div and remove elements from the div so they don't stack up on each other
				$("#msgClose").click(function(e) {
					e.preventDefault();
					$("#popupContact").velocity("transition.bounceUpOut");
					$("#greyOut").velocity("transition.fadeOut",{delay:200});
					$("#msgImg").remove();
					$("#msgH1").remove();
					$("#msgClose").remove();			
				});
				
				console.log(results);
			},
			error: function(results) {
				//style and add content to a status div that pops up to provide feedback on how the update went
				$("#greyOut").velocity("transition.fadeIn")
				.velocity({opacity:0.9});
				$("#popupContact").velocity("transition.bounceDownIn")
				.velocity({opacity:1});
				$("#popupContact").prepend('<img id="msgImg" src="../images/cross.svg" /> <h1 id="msgH1">Sorry we could not create your PBI.</h1> <br> <a href="#" id="msgClose">OK</a>');
				
				//Close popup div and remove elements from the div so they don't stack up on each other$("#msgClose").click(function(e) {
				$("#msgClose").click(function(e) {
					e.preventDefault();
					$("#popupContact").velocity("transition.bounceUpOut");
					$("#greyOut").velocity("transition.fadeOut",{delay:200});
					$("#msgImg").remove();
					$("#msgH1").remove();
					$("#msgClose").remove();			
				});
				console.log(results);
			}
		});
	  }
	});
	return false;
 });