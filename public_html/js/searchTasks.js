/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to search for Pbi's based on values entered into filter drop down boxes
/*================================================================================================================*/
/*================================================================================================================*/
$(document).ready(function() {
	$.ajax({
			dataType: "json",
			//This php file returns the options available in the search filter boxes
			url: "../php/TaskDropDown.php",
			//if the ajax call is successful run the function load - 
			//this contains a parent function for everything else in this JS file
			success: function load (result) {
				populateDropDowns(result);
			}            
		});
});

//This function acts as a parent function and is fired on the success call back of the above AJAX request
function populateDropDowns(results) {
	
	// Variables 
	var project = $("#projects");
	var sprint = $("#sprints");
	var state = $("#pbiState");
	var phpProjectValues = [];
	var phpSprintValues = [];
	var phpStateValues = [];
	
	//The JSON array returned by the php file is an array of arrays this each loop goes through each of
	//the child arrays and sets the equal to a variable.
	$.each(results, function (key, value){
		phpProjectValues = value[0];
		phpSprintValues = value[1];
		phpStateValues = value[2];
	});
	
	//Get the values out of the child array variables and append the values to the search filter boxes
	//And to the Pbi detail form to aid user choice when creating a PBI through the Zeus UI
		
	//Populate the first child variable with project values
	$.each(phpProjectValues,function(key,value){
		project.append('<option value="'+ value.projectName +'">' + value.projectName +'</option>')
	})
	
	//Populate the PBI form project drop down with project values
	$.each(phpProjectValues,function(key,value){
		$("#taskProject").append('<option value="'+ value.projectName +'">' + value.projectName +'</option>')
	})
	
	//Populate the second child variable with Sprint name values
	$.each(phpSprintValues,function(key,value){
		sprint.append('<option value="'+ value.IterationName +'">' + value.IterationName +'</option>')
	})
	
	//Populate the PBI form Iteration drop down with Sprint name values
	$.each(phpSprintValues,function(key,value){
		$("#taskIteration").append('<option value="'+ value.IterationName +'">' + value.IterationName +'</option>')
	})
	
	//Populate the fourth child variable with state values
	$.each(phpStateValues,function(key,value){
		state.append('<option value="'+ value.State +'">' + value.State +'</option>')
	})
	
	//Populate the PBI form State drop down with state values
	$.each(phpStateValues,function(key,value){
		$("#taskDetailState").append('<option value="'+ value.State +'">' + value.State +'</option>')
	})
	
	//perform another AJAX request to populate the results table based on parameters in drop down boxes	
    $("#pbiSearch").click(function(e) {
        e.preventDefault();
	  //This PHP file returns the PBI's that match the values entered into the drop down boxes
	  $.ajax({
		type: "POST",
		url: "../php/SearchTasks.php",
		data: {
			postedProject:project.val(),
			postedSprint: sprint.val(),
			postedState:state.val()
		},
		dataType: "json",
		success: function createPBITable (pbis){
			PBI(pbis);			 
		},
		error: function() {
			console.log('error')
		}
	  });
	
	});
   	return false;
	
	//function called by the success callback of the above Ajax request
	function PBI(results){
			var taskID = [];
			var taskTitle = [];
			var table = document.getElementById('pBIResultstable')
			var rows = table.getElementsByTagName('tr').length;
			var clickedPBIID;
			
			//if the number of rows in the results table is greater than one - delete the rows in preparation for fresh data
			if (rows > 1){
				//console.log(rows);
				for (i=rows-1; i>0; i--){
					table.deleteRow(i);
				}
			}
			else {
			}
			
			//Process the results of the query based on the parameters supplied from drop down box
			$.each(results, function (key, value) {
			    var a = value.taskId;
				var b = value.taskTitle;	
                taskID.push(a);   
				taskTitle.push(b);           
	            });
				
				//For every row of results add a row to the results table
				for (i=0; i<results.length; i++) {
					$("#pBIResultstable") .append('<tr class="PBI">'+
					'<td>'+taskID[i] +'</td>'+
					'<td>'+taskTitle[i] +'</td>'+
					'</tr>');
				};
			
			//Wait for a Pbi to be clicked on and when it is get the ID of that PBI so that more details can be shown about that PBI
			$(".PBI").click(function(e) {
				e.preventDefault();
				
				//This looks at the parent row of the cell being clicked on and gets the first child of that row which will always be the ID
				var clickedTaskID = e.target.parentNode.firstChild.textContent;
				
				//Now use the ID found above in where clause of a SQL query to return back more specific information about that PBI
				$.ajax({
				type: "POST",
				url: "../php/TaskDetails.php",
				data: {
					postedTaskID:clickedTaskID,
				},
				dataType: "json",
				success: function createPBIDetails (pbiData){
					PBIDetails(pbiData);			 
				},
				error: function() {
					console.log('error')
				}
				});
	
			});
			return false;
			
			//Display the results of the query to the right of the results table called by the success callback of the AJAX request directly above
			function PBIDetails(results){

				var taskIDField = document.getElementById("taskID");
				var taskTitleField = document.getElementById("taskTitle");
				var pbiTitleField = document.getElementById("pbiTitle");
				var assigneeField = document.getElementById("assignee");
				var taskDescField = document.getElementById("taskDescription");
				var estimatedTimeField = document.getElementById("estimatedTime");
				var timeSpentField = document.getElementById("timeSpent");
				var taskStateField = document.getElementById("taskDetailState");
				var taskIterationField = document.getElementById("taskIteration");
				var taskProjectField = document.getElementById("taskProject");
				
				//Show the pbiDetails form and show the update and delete button
				$('#pbiDetails').velocity({opacity:1}, {duration:200});
				$('#pbiDetailsButton').show();
				$('#pbiDetailsButton').css("visibility","visible");
				$('#pbiDetailsButton').velocity({opacity:1}, {duration:0});
				$('#deletePbiButton').show();
				$('#deletePbiButton').css("visibility","visible");
				$('#deletePbiButton').velocity({opacity:1}, {duration:0});
				
				//Make sure the create button is not shown
				$('#createPBI').hide();
				$('#createPBI').css("visibility","hidden");
	 			$('#createPBI').velocity({opacity:0}, {duration:0});
				
				//Apply the results of the query based on the ID selected from above to the fields in the PBI form on the right hand side of the page.
				$.each(results, function(key,value){
					taskIDField.value = value.taskId;
					taskTitleField.value = value.taskTitle;
					pbiTitleField.value = value.pbiTitle;
					assigneeField.value = value.assignee;
					taskDescField.value = value.taskDesc;
					estimatedTimeField.value = value.taskEstTime;
					timeSpentField.value = value.taskHoursDone;
					taskStateField.value = value.state;
					taskIterationField.value = value.itName;
					taskProjectField.value = value.project;
				})
			};
	};
};