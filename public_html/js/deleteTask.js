/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to process the update of any PBI displayed in the PBI form
/*================================================================================================================*/
/*================================================================================================================*/

 $(function () {
	 
	$("#deletePbiButton").click(function(e) {	
		e.preventDefault() 
		//Variables 
		var updateID = document.getElementById("taskID").value;
		
		//Check if the ID field is empty before submitting - if it is then do not submit the data
		//And provide a suitable error message
		if (updateID == null || updateID == ""){
			//style and add content to a status div that pops up to provide feedback on how the update went
				$("#greyOut").velocity("transition.fadeIn")
				.velocity({opacity:0.9});
				$("#popupContact").velocity("transition.bounceDownIn")
				.velocity({opacity:1});
				$("#popupContact").prepend('<img id="msgImg" src="../images/cross.svg" /> <h1 id="msgH1">We could not delete this task, the ID field is empty.</h1> <br> <a href="#" id="msgClose">Cancel</a>');
				
				//Close popup div and remove elements from the div so they don't stack up on each other$("#msgClose").click(function(e) {
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
			$("#popupContact").prepend('<img id="msgImg" src="../images/query.svg" /> <h1 id="msgH1">Are you sure you want to delete this task?</h1> <br> <a href="#" id="confirmButton">Yes</a> <a href="#" id="msgClose">No</a>');
			
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
					url: "../php/DeleteTask.php",
					data: {
						postedID:updateID,
					},
					success: function(results) {
						//style and add content to a status div that pops up to provide feedback on how the update went
						console.log(results);
						$("#greyOut").velocity("transition.fadeIn")
						.velocity({opacity:0.9});
						$("#popupContact").velocity("transition.bounceDownIn")
						.velocity({opacity:1});
						$("#popupContact").prepend('<img id="msgImg" src="../images/tick.svg" /> <h1 id="msgH1">Your task was successfully deleted!</h1> <br> <a href="#" id="msgClose">Ok</a>');
						
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
						//style and add content to a status div that pops up to provide feedback on how the update went
						// $("#greyOut").velocity("transition.fadeIn")
						// .velocity({opacity:0.9});
						// $("#popupContact").velocity("transition.bounceDownIn")
						// .velocity({opacity:1});
						$("#popupContact").prepend('<img id="msgImg" src="../images/cross.svg" /> <h1 id="msgH1">Sorry we could not delete your task.</h1> <br> <a href="#" id="msgClose">Ok</a>');
						
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