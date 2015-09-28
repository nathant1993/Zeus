/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to search for Pbi's based on values entered into filter drop down boxes
/*================================================================================================================*/
/*================================================================================================================*/

$(document).ready(function() {
	$.ajax({
			dataType: "json",
			//This php file returns the options available in the search filter boxes
			url: "../php/DropDown.php",
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
	var priority = $("#pbiPriority");
	var state = $("#pbiState");
	var phpProjectValues = [];
	var phpSprintValues = [];
	var phpPriorityValues = [];
	var phpStateValues = [];
	
	//The JSON array returned by the php file is an array of arrays this each loop goes through each of
	//the child arrays and sets the equal to a variable.
	$.each(results, function (key, value){
		phpProjectValues = value[0];
		phpSprintValues = value[1];
		phpPriorityValues = value[2];
		phpStateValues = value[3];
	});
	
	//Now get the values out of the child array variables and append the values to the search filter boxes	
	//First child variable
	$.each(phpProjectValues,function(key,value){
		project.append('<option value="'+ value.projectName +'">' + value.projectName +'</option>')
	})
	
	//Second child variable
	$.each(phpSprintValues,function(key,value){
		sprint.append('<option value="'+ value.IterationName +'">' + value.IterationName +'</option>')
	})
	
	//Third child variable
	$.each(phpPriorityValues,function(key,value){
		priority.append('<option value="'+ value.Priority +'">' + value.Priority +'</option>')
	})
	
	//Fourth child variable
	$.each(phpStateValues,function(key,value){
		state.append('<option value="'+ value.State +'">' + value.State +'</option>')
	})
	
	//perform another AJAX request to populate the results table based on parameters in drop down boxes	
    $("#pbiSearch").click(function(e) {
        e.preventDefault();
	  //This PHP file returns the PBI's that match the values entered into the drop down boxes
	  $.ajax({
		type: "POST",
		url: "../php/SearchPBIs.php",
		data: {
			postedProject:project.val(),
			postedSprint: sprint.val(),
			postedPriority: priority.val(),
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
			var pbiID = [];
			var pbiTitle = [];
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
			    var a = value.pbiId;
				var b = value.pbiTitle;	
                pbiID.push(a);   
				pbiTitle.push(b);           
	            });
				
				//For every row of results add a row to the results table
				for (i=0; i<results.length; i++) {
					$("#pBIResultstable") .append('<tr class="PBI">'+
					'<td>'+pbiID[i] +'</td>'+
					'<td>'+pbiTitle[i] +'</td>'+
					'</tr>');
				};
			
			//Wait for a Pbi to be clicked on and when it is get the ID of that PBI so that more details can be shown about that PBI
			$(".PBI").click(function(e) {
				e.preventDefault();
				
				//This looks at the parent row of the cell being clicked on and gets the first child of that row which will always be the ID
				clickedPBIID = e.target.parentNode.firstChild.textContent;
				
				//Now use the ID found above in where clause of a SQL query to return back more specific information about that PBI
				$.ajax({
				type: "POST",
				url: "../php/PBIDetails.php",
				data: {
					postedPBIID:clickedPBIID,
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

				var pbiIDField = document.getElementById("pbiID");
				var pbiTitleField = document.getElementById("pbiTitle");
				var pbiDescField = document.getElementById("pbiDescription");
				var pbiEffortField = document.getElementById("pbiEffort");
				var pbiPriorityField = document.getElementById("pbiDetailPriority");
				var pbiStateField = document.getElementById("pbiDetailState");
				var pbiIterationField = document.getElementById("pbiIteration");
				var pbiProjectField = document.getElementById("pbiProject");
				
				$('#pbiDetails').velocity({opacity:1}, {duration:200});
				$('#createPBI').velocity({opacity:0}, {duration:50});
				$('#pbiDetailsButton').velocity({opacity:1}, {duration:200});
				
				//Apply the results of the query based on the ID selected from above to the fields in the PBI form on the right hand side of the page.
				$.each(results, function(key,value){
					pbiIDField.value = value.pbiId;
					pbiTitleField.value = value.pbiTitle;
					pbiDescField.value = value.pbiDesc;
					pbiEffortField.value = value.pbiEff;
					pbiPriorityField.value = value.priority;
					pbiStateField.value = value.state;
					pbiIterationField.value = value.itName;
					pbiProjectField.value = value.project;
				})
			};
	};
};