/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to display sprints based on what tab in the left hand table is clicked on
/*================================================================================================================*/
/*================================================================================================================*/

$(document).ready(function() {
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
	
	var sprintNoFromURL = getUrlParameter("SprintNo");
		
	if (sprintNoFromURL != null){
		//console.log(sprintNoFromURL);
	
		$.ajax({
            type: "POST",
			data: {postedSprintNoFromURL:sprintNoFromURL},
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
	}
	else{
		$.ajax({
			dataType: "json",
			//This php file returns the options available in the search filter boxes
			url: "../php/SearchSprints.php",
			//if the ajax call is successful run the function load - 
			//this contains a parent function for everything else in this JS file
			success: function normalload (result) {
				populateSprints(result);
				dragAndDrop();
			}            
		});
	}
});

//This function acts as a parent function and is fired on the success call back of the above AJAX request
function populateSprints(results) {
		
		var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;
		
			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');
		
				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : sParameterName[1];
				}
			}
		};
	
		var sprintNoFromURL = getUrlParameter("SprintNo");
		var iterationID = [];
		var iterationName = [];
		var iterationStart = [];
		var iterationEnd = [];
		var iterationStartReadable = [];
		var iterationEndReadable = [];
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
		
		//console.log(SprintResults);
		//console.log(PbiResults);
		//console.log(TaskResults);
		
		$.each(SprintResults, function (key, value) {
			var a = value.itID;
			var b = value.itName;
			var c = value.itStart;
			var d = value.itEnd;
			var e = value.itStartReadable;
			var f = value.itEndReadable;
				
			iterationID.push(a);   
			iterationName.push(b);
			iterationStart.push(c);
			iterationEnd.push(d);
			iterationStartReadable.push(e);
			iterationEndReadable.push(f);            
		});
		
        //if no paramter was passed in the URL then show the current sprint
        if (sprintNoFromURL == null) {
            //The page will load on the current sprints tab of the table so highlight it accordingly
            $("#currentSprints").addClass("SelectedSprintType");
		
            //Show the current sprint in the sprint table when the page is loaded
            //For every row of results add a row to the results table
            for (i = 0; i < SprintResults.length; i++) {
                
                //Cast the iteration dates from the results of the query to dates
                var itStartDate = new Date(iterationStart[i]);
				var itEndDate = new Date(iterationEnd[i]);
                var itStartDateTitle = iterationStartReadable[i];
				var itEndDateTitle = iterationEndReadable[i];
			
                //To show the current sprint find the sprint date 
                if (itEndDate >= date && itStartDate <= date) {
                    $("#sprintsTable").append('<tr class="PBI">' +
                        '<td style="display:none">' + iterationID[i] + '</td>' +
                        '<td>' + iterationName[i] + '</td>' +
                        '</tr>');
					$("h1", ".twoThirdsWidth").append(iterationName[i]);
					//$("h2", ".twoThirdsWidth").append("Sprint Start:" + itStartDate.toDateString() + "     " + "Sprint End:" + itEndDate.toDateString());
					$("h2", ".twoThirdsWidth").append("Sprint Start: " + itStartDateTitle);	
					$("h3", ".twoThirdsWidth").append("Sprint End: " + itEndDateTitle);
                };
				
            };
        }
        
        //If a paramter was passed in the URL then the below needs to happen to show the correct sprint in the left hand sprint table
        else {
            // a new array is needed to store sprint names without their project prefix
            var shortIterationName = [];
            
            //for each of the iteration names remove everything before the - in the name
            for (i = 0; i < iterationName.length; i++) {
                var str = iterationName[i]
                str = str.substring(str.indexOf("-") + 2)
                shortIterationName.push(str);
            }
            
            //Now the sprint name from the URL can be compared to the shorted array of names to find a position within that array
            var clickedSprintArrayNo = shortIterationName.indexOf(sprintNoFromURL);
            
            //This position is used in the original iterationName array to show a properly formatted sprint name in th esprint table
            $("#sprintsTable").append('<tr class="PBI">' +
                '<td style="display:none">' + iterationID[clickedSprintArrayNo] + '</td>' +
                '<td>' + iterationName[clickedSprintArrayNo] + '</td>' +
                '</tr>');
        };
        
        //Show all of the pbis returned by the query at the beginning
		try{
			$.each(PbiResults,function(key,value){
				board.append('<div class="KanbanRow" data-pbiID=' + value.pbiId + '>' +
				'<div id="PBI' + value.pbiId + '" class="kanbanColumn">'+
					'<div id="'+ value.pbiId + '" class="PBIResult">'+
					'<div class="pbiTitle">'+
						value.pbiTitle +
					'</div>'+ 
					'</div>'+
					'</div><div id= "todo' + value.pbiId + '" class="todo">'+
					'</div><div id="inprogress' + value.pbiId + '" class="inprogress">'+
					'</div><div id="done' + value.pbiId + '" class="done">'+
					'</div>'+              
				'</div>'
				);
			});
		}
		catch (error) {
		//console.log("caught null array");
		}
		
        //Show all of the tasks related to the PBIs returned above and place them into their respective columns depending on their state
		//with a thumbnail photo of the person the work is assigned to, also handle there being no photo present.
		try{	
			$.each(TaskResults, function (key,value){
				if(value.stateID == 7){
					if(value.photoAddress != null){
						$('#todo' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
							'<div class="cardTitle">'+
								value.taskTitle + 
							'</div>'+
							'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
							'<img src =' + value.photoAddress + '>' +
							'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
							'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
							'</div>'
						);
					}
					else{
						$('#todo' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
							'<div class="cardTitle">'+
								value.taskTitle + 
							'</div>'+
							'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
							'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
							'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
							'</div>'
						);
					}
				}
				else if(value.stateID == 8){
					if(value.photoAddress != null){
						$('#inprogress' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
							'<div class="cardTitle">'+
								value.taskTitle +
							'</div>'+
							'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
							'<img src =' + value.photoAddress + '>' +
							'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
							'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
							'</div>'
						);
					}
					else{
						$('#inprogress' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
							'<div class="cardTitle">'+
								value.taskTitle +
							'</div>'+
							'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
							'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
							'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
							'</div>'
						);
					}
				}
				else if(value.stateID >= 9){
					if(value.photoAddress != null){
						$('#done' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
							'<div class="cardTitle">'+
								value.taskTitle +
							'</div>'+
							'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
							'<img src =' + value.photoAddress + '>' +
							'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
							'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
							'</div>'
						);
					}
					else{
						$('#done' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
							'<div class="cardTitle">'+
								value.taskTitle +
							'</div>'+
							'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
							'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
							'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
							'</div>'
						);
					}
				};
				
				//add a border to tasks to visually represent the priority of the tasks
				//if the task is critcal add a pink border		
				// if(value.priorityId == 1){
				// 	var task = $("'#task" + value.taskId + "'");
				// 	console.log(task);
				// 	task.css({"border-left":"11px solid #69a6cd"});
				// }
				// //if the task has a high priority then add a yellow border
				// else if(value.priorityId == 2){
					
				// }
				// //if the task has a medium priority then add a blue border
				// else if(value.priorityId == 3){
				// 	var task = $("'#task" + value.taskId + "'");
				// 	console.log(task);
				// 	task.css({"border-left":"11px solid #69a6cd"});
				// }
				// //if the task has a low priority then add a green border
				// else if(value.priorityId == 4){
					
				// }	
			});
		} 
		catch (error) {
		//console.log("caught null array");
		}
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
				
				var sprintDetails = [];
				var taskDetails = [];
				var pbisForSprint =[];
				
				//Tidy up the Kanban board and remove any old Kanban rows before displaying the ones that apply to the selected sprint
				$('.KanbanRow').remove();
				
				//result from AJAX request is an array of arrays, this gets each of the individual arrays.
				$.each(results, function (key, value){
					sprintDetails = value[0]
					taskDetails = value[1];
					pbisForSprint = value[2];
				});
				
				//For each loop to iterate over each pbi returned and apply a new kanban row to the board.
				try{
					$.each(sprintDetails, function (key,value){
						$("h1", ".twoThirdsWidth").empty().append(value.itName);
						$("h2", ".twoThirdsWidth").empty().append("Sprint Start: " + value.itStartReadable);	
						$("h3", ".twoThirdsWidth").empty().append("Sprint End: " + value.itEndReadable);
					})	
				}
				catch(error){}
				
				try {
					$.each(pbisForSprint,function(key,value){
						board.append('<div class="KanbanRow" data-pbiID=' + value.pbiId + '>' +
						'<div id="PBI' + value.pbiId + '" class="kanbanColumn">'+
							'<div id="'+ value.pbiId + '" class="PBIResult">'+
							'<div class="pbiTitle">'+
								value.pbiTitle +
							'</div>'+ 
							'</div>'+
							'</div><div id= "todo' + value.pbiId + '" class="todo">'+
							'</div><div id="inprogress' + value.pbiId + '" class="inprogress">'+
							'</div><div id="done' + value.pbiId + '" class="done">'+
							'</div>'+              
						'</div>'
						);
					});
				}
				catch (error) {
				//console.log("caught null task array");
				}
				
				try {
					$.each(taskDetails, function (key,value){
						if(value.stateID == 7){
							if(value.photoAddress != null){
								$('#todo' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
									'<div class="cardTitle">'+
										value.taskTitle + 
									'</div>'+
									'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
									'<img src =' + value.photoAddress + '>' +
									'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
									'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
									'</div>'
								);
							}
							else{
								$('#todo' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
									'<div class="cardTitle">'+
										value.taskTitle + 
									'</div>'+
									'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
									'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
									'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
									'</div>'
								);
							}
						}
						else if(value.stateID == 8){
							if(value.photoAddress != null){
								$('#inprogress' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
									'<div class="cardTitle">'+
										value.taskTitle +
									'</div>'+
									'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
									'<img src =' + value.photoAddress + '>' +
									'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
									'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
									'</div>'
								);
							}
							else{
								$('#inprogress' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
									'<div class="cardTitle">'+
										value.taskTitle +
									'</div>'+
									'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
									'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
									'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
									'</div>'
								);
							}
						}
						else if(value.stateID >= 9){
							if(value.photoAddress != null){
								$('#done' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
									'<div class="cardTitle">'+
										value.taskTitle +
									'</div>'+
									'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
									'<img src =' + value.photoAddress + '>' +
									'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
									'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
									'</div>'
								);
							}
							else{
								$('#done' + value.pbiID).append('<div id="Task' + value.taskId +'" class="Task" draggable="true" data-pbiID=' + value.pbiID + '>'+
									'<div class="cardTitle">'+
										value.taskTitle +
									'</div>'+
									'<p><strong>Priority:</strong> '+ value.priorityDesc +'</p>'+
									'<p><strong>Assignee:</strong> '+ value.assignee +'</p>'+
									'<p><strong>Time spent:</strong> '+ value.taskHoursDone +'</p>'+
									'</div>'
								);
							}
						};	
					});
				} 
				catch (error) {
				//console.log("caught null task array");
				}
                $('.Task').dblclick(function(e){
            location = "./tasks.php?taskId=" + this.id.substring(4)
        })
        
        $('.PBIResult').dblclick(function(e){
            location = "./backlog.php?PBIId=" + this.id
        })
			};
		};
        
        $('.Task').dblclick(function(e){
            location = "./tasks.php?taskId=" + this.id.substring(4)
        })
        
        $('.PBIResult').dblclick(function(e){
            location = "./backlog.php?PBIId=" + this.id
        })
        
};


function dragAndDrop(){
	$('.Task').on('dragstart', function(event) {
			event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
			//console.log(event.target.getAttribute('id'));  
		});

		$('.todo').on('dragover', function(event) {
			event.preventDefault();
		});
		
		$('.inprogress').on('dragover', function(event) {
			event.preventDefault();
		});
		
		$('.done').on('dragover', function(event) {
			event.preventDefault();
		});
		
		$('Body').on('drop', '.KanbanRow', function(event) {
			event.preventDefault();
			event.stopImmediatePropagation();
			
			var notecard = event.originalEvent.dataTransfer.getData("text/plain");
			var taskPbiID = document.getElementById(notecard).dataset.pbiid;
			var rowPbiId = event.target.parentNode.dataset.pbiid;
			
			if(taskPbiID == rowPbiId){
			
				if($(event.target).attr('class') === 'todo'){
					event.target.appendChild(document.getElementById(notecard));
					console.log('Moved to to do');
					//console.log($(event.target).attr('id'));
					changeTaskState(7,notecard);
				}						
				else if ($(event.target).attr('class') === 'inprogress'){
					event.target.appendChild(document.getElementById(notecard));
					changeTaskState(8,notecard);
					console.log('Moved to in progress');
				}
				else if ($(event.target).attr('class') === 'done'){
					event.target.appendChild(document.getElementById(notecard));
					changeTaskState(10,notecard);
					console.log('Moved to done');
				}
			};
		});
};

function changeTaskState(stateID,taskName){
	$.ajax({
		type: "POST",
		url: "../php/ChangeTaskState.php",
		beforeSend: function(){
			$('#'+ taskName).addClass("lock");
			document.getElementById(taskName).setAttribute("draggable", "false");
		},
		data: {
			postedStateID:stateID,
			postedTaskName:taskName
		},
		dataType: "json",
		success: function() {
							 
		},
		error: function(result) {
			//console.log(result)
		},
		complete: function(){
			$('#'+ taskName).removeClass("lock");
			document.getElementById(taskName).setAttribute("draggable", "true");
		}
	});
	
}

