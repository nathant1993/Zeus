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
				dragAndDrop();
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
		var SprintResults = [];
		var PbiResults = [];
		var TaskResults = [];
		var board = $('#board');

		//Process the results of the query based on the parameters supplied from drop down box
		
		$.each(results, function (key, value){
					SprintResults = value[0];
					PbiResults = value[1];
					TaskResults = value[2];
				});
		
		$.each(SprintResults, function (key, value) {
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
		for (i=0; i<SprintResults.length; i++) {
			
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
		
		$.each(PbiResults,function(key,value){
			board.append('<div class="KanbanRow">' +
			'<div id="PBI' + value.pbiId + '" class="kanbanColumn">'+
				'<div id="'+ value.pbiId + '" class="Task">'+
				'<div class="cardTitle">'+
					value.pbiTitle +
				'</div>'+ 
				'</div>'+
				'</div><div id= "todo' + value.pbiId + '" class="kanbanColumn">'+
				'</div><div id="inprogress' + value.pbiId + '" class="kanbanColumn">'+
				'</div><div id="done' + value.pbiId + '" class="kanbanColumn">'+
				'</div>'+              
			'</div>'
			);
		});
	
		$.each(TaskResults, function (key,value){
			if(value.stateID == 7){
				$('#todo' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true">'+
					'<div class="cardTitle">'+
						value.taskTitle +
					'</div>'+
					'</div>'
				);
			}
			else if(value.stateID == 8){
				$('#inprogress' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true">'+
					'<div class="cardTitle">'+
						value.taskTitle +
					'</div>'+
					'</div>'
				);
			}
			else if(value.stateID >= 9){
				$('#done' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true">'+
					'<div class="cardTitle">'+
						value.taskTitle +
					'</div>'+
					'</div>'
				);
			};	
			
		});
		
		//Wait for the current sprint tab to be clicked and show any current sprints
		$("#currentSprints").click(function(e) {
        e.preventDefault();	
		
			//Tidy up and remove any orange highlighting from a previously selected tab
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
			for (i=0; i<SprintResults.length; i++) {
			
				var itEndDate = new Date(iterationEnd[i])
				var itStartDate = new Date(iterationStart[i])
				
				//Some data processing on the client side to prevent needing multiple AJAX calls
				if(itEndDate >= date && itStartDate < date){
					$("#sprintsTable").append('<tr class="PBI">'+
					'<td style="display:none">'+ iterationID[i] +'</td>'+
					'<td>'+ iterationName[i] +'</td>'+
					'</tr>');
				};
			};
			
			showSprintData();
				
		});
		
		//Wait for the previous sprints tab to be clicked and show any previous sprints	
		$("#previousSprints").click(function(e) {
        e.preventDefault();	
		
			//Tidy up and remove any orange highlighting from a previously selected tab
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
			for (i=0; i<SprintResults.length; i++) {
			
				var itEndDate = new Date(iterationEnd[i])
				
				//Some data processing on the client side to prevent needing multiple AJAX calls
				if(itEndDate < date){
					$("#sprintsTable").append('<tr class="PBI">'+
					'<td style="display:none">'+ iterationID[i] +'</td>'+
					'<td>'+ iterationName[i] +'</td>'+
					'</tr>');
				};
			};
			
			showSprintData();
				
		});
		
		//Wait for the future sprint tab to be clicked and show any future sprints
		$("#futureSprints").click(function(e) {
        e.preventDefault();	
		
			//Tidy up and remove any orange highlighting from a previously selected tab
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
			for (i=0; i<SprintResults.length; i++) {
			
				var itStartDate = new Date(iterationStart[i])
				
				//Some data processing on the client side to prevent needing multiple AJAX calls
				if(itStartDate > date){
					$("#sprintsTable").append('<tr class="PBI">'+
					'<td style="display:none">'+ iterationID[i] +'</td>'+
					'<td>'+ iterationName[i] +'</td>'+
					'</tr>');
				};
			};
			
			showSprintData();
				
		});
		
		//function to display PBI's based on selected Sprint
		function showSprintData(){
			
			//Wait for a sprint to be clicked on and when it is get the ID of that sprint so that more details can be shown about that PBI
			$(".PBI").click(function(e) {
				e.preventDefault();
				
				//This looks at the parent row of the cell being clicked on and gets the first child of that row which will always be the ID
				clickedSprintID = e.target.parentNode.firstChild.textContent;
	
				//Now use the ID found above in where clause of a SQL query to return back more specific information about that PBI
				$.ajax({
				type: "POST",
				url: "../php/SprintDetails.php",
				data: {
					postedSprintID:clickedSprintID,
				},
				dataType: "json",
				success: function load (sprintData){
					SprintDetails(sprintData);
					dragAndDrop();			 
				},
				error: function() {
					console.log('error')
				}
				});
	
			});
			return false;
			
			//Display the results of the query to the right of the results table, this function is called by the success callback of the AJAX request directly above
			function SprintDetails(results){
				
				var taskDetails = [];
				var pbisForSprint =[];
				
				//Tidy up the Kanban board and remove any old Kanban rows before displaying the ones that apply to the selected sprint
				$('.KanbanRow').remove();
				
				//result from AJAX request is an array of arrays, this gets each of the individual arrays.
				$.each(results, function (key, value){
					taskDetails = value[0];
					pbisForSprint = value[1];
				});
				
				console.log(taskDetails);
				//console.log(pbisForSprint);
				
				//For each loop to iterate over each pbi returned and apply a new kanban row to the board.
				$.each(pbisForSprint,function(key,value){
					board.append('<div class="KanbanRow">' +
					'<div id="PBI' + value.pbiId + '" class="kanbanColumn">'+
						'<div id="'+ value.pbiId + '" class="Task">'+
						'<div class="cardTitle">'+
							value.pbiTitle +
						'</div>'+ 
						'</div>'+
						'</div><div id= "todo' + value.pbiId + '" class="kanbanColumn">'+
						'</div><div id="inprogress' + value.pbiId + '" class="kanbanColumn">'+
						'</div><div id="done' + value.pbiId + '" class="kanbanColumn">'+
						'</div>'+              
					'</div>'
					);
				});
				
				$.each(taskDetails, function (key,value){
					if(value.stateID == 7){
						$('#todo' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true">'+
                      		'<div class="cardTitle">'+
                          		value.taskTitle +
                      		'</div>'+
                  			'</div>'
						);
					}
					else if(value.stateID == 8){
						$('#inprogress' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true">'+
                      		'<div class="cardTitle">'+
                          		value.taskTitle +
                      		'</div>'+
                  			'</div>'
						);
					}
					else if(value.stateID >= 9){
						$('#done' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true">'+
                      		'<div class="cardTitle">'+
                          		value.taskTitle +
                      		'</div>'+
                  			'</div>'
						);
					};	
					
				});
			};
		};
};


function dragAndDrop(){
	$('.Task').on('dragstart', function(event) {
		//$(document).on('dragstart', '.Task', function(event) {
			event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
			//console.log(event.target.getAttribute('id'));  
		});

		$('.kanbanColumn').on('dragover', function(event) {
			event.preventDefault();
		});
		
		$('Body').on('drop', '.kanbanColumn', function(event) {
	
			var notecard = event.originalEvent.dataTransfer.getData("text/plain");;
			
			if($(event.target).attr('class') === 'kanbanColumn'){
				event.target.appendChild(document.getElementById(notecard));
			
				console.log($(event.target).attr('id'));
				$(event.target).attr([id *= 'todo'])
							
				if($('event.target[id *= "todo"]')){
					changeTaskState(7,notecard);
					console.log('Moved to to do');
				}
				else if ($('event.target[id *= "inprogress"]')){
					changeTaskState(8,notecard);
					console.log('Moved to in progress');
				}
				else if ($('event.target[id *= "done"]')){
					changeTaskState(9,notecard);
					console.log('Moved to done');
				}
				event.preventDefault();
			}
		});
};

function changeTaskState(stateID,taskName){
	$.ajax({
		type: "POST",
		url: "../php/ChangeTaskState.php",
		data: {
			postedStateID:stateID,
			postedTaskName:taskName
		},
		dataType: "json",
		success: function() {
			//dragAndDrop();			 
		},
		error: function(result) {
			console.log(result)
		}
	});
	
}