$(function () {
	
	/*populate the results table based on parameters in drop down box*/
	
    $(".formbutton").click(function(e) {
        e.preventDefault();
		
	  // Variables 
      var project = document.getElementById("projects").value;
	  var sprint = document.getElementById("sprints").value;
	  var priority = document.getElementById("pbiPriority").value;
	  var state = document.getElementById("pbiState").value;
	   console.log(project)
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
			var table = document.getElementById('testtable')
			var rows = table.getElementsByTagName('tr').length;
			
			//if the number of rows in the table is greater than one - delete the rows in preparation for fresh data
			if (rows > 1){
				//console.log(rows);
				for (i=rows-1; i>0; i--){
					table.deleteRow(i);
					console.log(i);
				}
			}
			else {
				console.log('no rows!')
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
					$("#testtable") .append('<tr>'+
					'<td>'+pbiID[i] +'</td>'+
					'<td>'+pbiTitle[i] +'</td>'+
					'</tr>');
				};
	};
	
});