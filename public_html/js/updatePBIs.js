/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to validate and process the email submssion field
/*================================================================================================================*/
/*================================================================================================================*/

 $(function () {

     $("#pbiDetailsButton").click(function(e) {
         e.preventDefault();

      // // Variables 
      // var emailfield = document.getElementById("emailAddress");
      var updateID = document.getElementById("pbiID").value;
	  var updateTitle = document.getElementById("pbiTitle").value;
	  var updateDesc = document.getElementById("pbiDescription").value;
	  var updateEffort = document.getElementById("pbiEffort").value;
	  var updatePriority = document.getElementById("pbiDetailPriority").value;
	  var updateState = document.getElementById("pbiDetailState").value;
	  var updateIteration = document.getElementById("pbiIteration").value;
	  var updateProject = document.getElementById("pbiProject").value;
	  
	  
      //ajax request to post email address to the database using DBCon PHP file.
	  $.ajax({
		type: "POST",
		url: "../php/UpdatePBI.php",
		data: {
			postedID:updateID,
			postedTitle:updateTitle,
			postedDesc:updateDesc,
			postedEffort:updateEffort,
			postedPriority:updatePriority,
			postedState:updateState,
			postedIteration:updateIteration,
			postedProject:updateProject
		},
		success: function(results) {
			console.log('success');
			console.log(results);
		},
		error: function(results) {
			console.log('error');
			console.log(results);
			
		}
	  });
	  
	  console.log("update submitted")
	
    });
     return false;
 });