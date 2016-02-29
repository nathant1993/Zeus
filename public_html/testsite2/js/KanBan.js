/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to control the kan ban board on the sprints.php page
/*================================================================================================================*/
/*================================================================================================================*/

// $(document).ready(function drag() {
// 	// $.ajax({
// 	// 		dataType: "json",
// 	// 		//This php file returns the options available in the search filter boxes
// 	// 		url: "../php/SearchSprints.php",
// 	// 		//if the ajax call is successful run the function load - 
// 	// 		//this contains a parent function for everything else in this JS file
// 	// 		success: function load (result) {
// 	// 			populateSprints(result);
// 	// 		}            
// 	// 	});
	
// 	$('.Task').on('dragstart', function(event) {
// 	//$(document).on('dragstart', '.Task', function(event) {
//   		event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
// 		console.log(event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id')));  
// 	});
	
// 	$('.kanbanColumn').on('dragover', function(event) {
// 		event.preventDefault();
// 	});
	
// 	$('Body').on('drop', '.kanbanColumn', function(event) {

// 		var notecard = event.originalEvent.dataTransfer.getData("text/plain");
		
// 		console.log(notecard);
		
// 		if($(event.target).attr('class') === 'kanbanColumn'){
// 			event.target.appendChild(document.getElementById("Task4"));
// 		}
		
// 		event.preventDefault();

// 	});
// });

//This function acts as a parent function and is fired on the success call back of the above AJAX request
// function populateSprints(results) {

// };