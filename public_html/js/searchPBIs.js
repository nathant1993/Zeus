$(function () {
	
	/*populate the results table based on parameters in drop down box*/
	
    $("#pbiSearch").click(function(e) {
        e.preventDefault();
		
	  // Variables 
      var project = document.getElementById("projects").value;
	  var sprint = document.getElementById("sprints").value;
	  var priority = document.getElementById("pbiPriority").value;
	  var state = document.getElementById("pbiState").value;
	  //console.log(project)
	  // console.log(sprint)
	  // console.log(priority)
	  // console.log(state)
	  
	  // ajax request to post the parameters to SearchPBIs.PHP file and return results
	  $.ajax({
		type: "POST",
		url: "../php/SearchPBIs.php",
		data: {
			postedProject:project,
			postedSprint: sprint,
			postedPriority: priority,
			postedState:state
		},
		dataType: "json",
		success: function createPBITable (pbis){
			//console.log(pbis); 
			PBI(pbis);			 
		},
		error: function() {
			console.log('error')
		}
	  });
	
	});
   	return false;
	
	//function called by the success callback of the Ajax request
	function PBI(results){
			var pbiID = [];
			var pbiTitle = [];
			var table = document.getElementById('pBIResultstable')
			var rows = table.getElementsByTagName('tr').length;
			var clickedPBIID;
			
			//if the number of rows in the table is greater than one - delete the rows in preparation for fresh data
			if (rows > 1){
				//console.log(rows);
				for (i=rows-1; i>0; i--){
					table.deleteRow(i);
					//console.log(i);
				}
			}
			else {
				//console.log('no rows!')
			}
			
			//Process the results of the query based on the parameters supplied from drop down box
			$.each(results, function (key, value) {
			    var a = value.pbiId;
				var b = value.pbiTitle;	
                pbiID.push(a);   
				pbiTitle.push(b);           
	            });
				//console.log(test);
				
				for (i=0; i<results.length; i++) {
					$("#pBIResultstable") .append('<tr class="PBI">'+
					'<td>'+pbiID[i] +'</td>'+
					'<td>'+pbiTitle[i] +'</td>'+
					'</tr>');
				};
			
			//Wait for a Pbi to be clicked on and when it is get the ID of that PBI	
			$(".PBI").click(function(e) {
				e.preventDefault();
				
				//This looks at the parent row of the cell being clicked on and gets the first child of that row which will always be the ID
				clickedPBIID = e.target.parentNode.firstChild.textContent;
				//console.log(clickedPBIID);
				
				//Now use the ID found above in a SQL query to return back more specific information about that PBI
				$.ajax({
				type: "POST",
				url: "../php/PBIDetails.php",
				data: {
					postedPBIID:clickedPBIID,
				},
				dataType: "json",
				success: function createPBIDetails (pbiData){
					//console.log(pbis); 
					PBIDetails(pbiData);			 
				},
				error: function() {
					console.log('error')
				}
				});
	
			});
			return false;
			
			//Display the results of the query to the right of the results table
			function PBIDetails(results){
				//console.log(results)
				var pbiIDField = document.getElementById("pbiID");
				var pbiTitleField = document.getElementById("pbiTitle");
				var pbiDescField = document.getElementById("pbiDescription");
				var pbiEffortField = document.getElementById("pbiEffort");
				var pbiPriorityField = document.getElementById("pbiDetailPriority");
				var pbiStateField = document.getElementById("pbiDetailState");
				var pbiIterationField = document.getElementById("pbiIteration");
				var pbiProjectField = document.getElementById("pbiProject");

				
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
});