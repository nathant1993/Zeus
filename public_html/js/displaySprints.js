/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to display sprints based on what tab in the left hand table is clicked on
/*================================================================================================================*/
/*================================================================================================================*/

$(document).ready(function() {
	$.ajax({
			dataType: "json",
			//This php file returns the options available in the search filter boxes
			url: "../php/SearchSprints.php",
			//if the ajax call is successful run the function load - 
			//this contains a parent function for everything else in this JS file
			success: function load (result) {
				populateSprints(result);
			}            
		});
});

//This function acts as a parent function and is fired on the success call back of the above AJAX request
function populateSprints(results) {

		var iterationID = [];
		var iterationName = [];
		var iterationStart = [];
		var iterationEnd = [];
		var table = document.getElementById('sprintsTable')
		var clickedPBIID;
		var date = new Date();

		//Process the results of the query based on the parameters supplied from drop down box
		$.each(results, function (key, value) {
			var a = value.itID;
			var b = value.itName;
			var c = value.itStart;
			var d = value.itEnd;
				
			iterationID.push(a);   
			iterationName.push(b);
			iterationStart.push(c);
			iterationEnd.push(d)            
		});
		
		//The page will load on the current sprints tab of the table so highlight it accordingly
		$("#currentSprints").addClass("SelectedSprintType");
		
		//Show the current sprint in the sprint table when the page is loaded
		
		//For every row of results add a row to the results table
		for (i=0; i<results.length; i++) {
			
			//Cast the iteration dates from the results of the query to dates
			var itEndDate = new Date(iterationEnd[i])
			var itStartDate = new Date(iterationStart[i])
			
			//To show the current sprint find teh sprint date 
			if(itEndDate >= date && itStartDate <= date){
				$("#sprintsTable").append('<tr class="PBI">'+
				'<td style="display:none">'+ iterationID[i] +'</td>'+
				'<td>'+ iterationName[i] +'</td>'+
				'</tr>');
			};
		};
		
		$("#currentSprints").click(function(e) {
        e.preventDefault();	
		
			$(".SelectedSprintType").removeClass("SelectedSprintType");
			$("#currentSprints").addClass("SelectedSprintType");
				
			var rows = table.getElementsByTagName('tr').length;
				
			//if the number of rows in the results table is greater than one - delete the rows in preparation for fresh data
			if (rows > 1){
				//console.log(rows);
				for (i=rows-1; i>0; i--){
					table.deleteRow(i);
				}
			}
			else {
			}
			
			//For every row of results add a row to the results table
			for (i=0; i<results.length; i++) {
			
				var itEndDate = new Date(iterationEnd[i])
				var itStartDate = new Date(iterationStart[i])
	
				if(itEndDate > date && itStartDate < date){
					$("#sprintsTable").append('<tr class="PBI">'+
					'<td style="display:none">'+ iterationID[i] +'</td>'+
					'<td>'+ iterationName[i] +'</td>'+
					'</tr>');
				};
			};
				
		});
			
		$("#previousSprints").click(function(e) {
        e.preventDefault();	
		
			$(".SelectedSprintType").removeClass("SelectedSprintType");
			$("#previousSprints").addClass("SelectedSprintType");
				
			var rows = table.getElementsByTagName('tr').length;
				
			//if the number of rows in the results table is greater than one - delete the rows in preparation for fresh data
			if (rows > 1){
				//console.log(rows);
				for (i=rows-1; i>0; i--){
					table.deleteRow(i);
				}
			}
			else {
			}
			
			//For every row of results add a row to the results table
			for (i=0; i<results.length; i++) {
			
				var itEndDate = new Date(iterationEnd[i])
	
				if(itEndDate < date){
					$("#sprintsTable").append('<tr class="PBI">'+
					'<td style="display:none">'+ iterationID[i] +'</td>'+
					'<td>'+ iterationName[i] +'</td>'+
					'</tr>');
				};
			};
				
		});
		
		$("#futureSprints").click(function(e) {
        e.preventDefault();	
		
			$(".SelectedSprintType").removeClass("SelectedSprintType");
			$("#futureSprints").addClass("SelectedSprintType");
				
			var rows = table.getElementsByTagName('tr').length;
				
			//if the number of rows in the results table is greater than one - delete the rows in preparation for fresh data
			if (rows > 1){
				//console.log(rows);
				for (i=rows-1; i>0; i--){
					table.deleteRow(i);
				}
			}
			else {
			}
			
			//For every row of results add a row to the results table
			for (i=0; i<results.length; i++) {
			
				var itStartDate = new Date(iterationStart[i])
	
				if(itStartDate > date){
					$("#sprintsTable").append('<tr class="PBI">'+
					'<td style="display:none">'+ iterationID[i] +'</td>'+
					'<td>'+ iterationName[i] +'</td>'+
					'</tr>');
				};
			};
				
		});
		
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