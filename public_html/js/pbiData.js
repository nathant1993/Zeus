/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to return PBI data
/*================================================================================================================*/
/*================================================================================================================*/

$(document).ready(function() {
	        $.ajax({
	            dataType: "json",
	            url: "./php/PBIData.php",
				success: function createArray (pbis) {
                    PBI(pbis);
                    //console.log(pbis);
				}         
	        });
			
/*================================================================================================================*/
/*================================================================================================================*/			
// On the success of the above AJAX call Create a table of PBI's on the page
/*================================================================================================================*/
/*================================================================================================================*/

			function PBI(results){
			var pbiID = [];
			var pbiTitle = [];
			var pbiDesc = [];
		   	var pbiEff = [];
		    var priority = [];
		    var state = [];
		    var project= [];
			
			$.each(results, function (key, value) {
			    var a = value.pbiId;
				var b = value.pbiTitle;
				var c = value.pbiDesc;
				var d = value.pbiEff;
				var e = value.priority;
				var f = value.state;
				var g = value.project;
				
                pbiID.push(a);   
				pbiTitle.push(b); 
				pbiDesc.push(c);
				pbiEff.push(d);
				priority.push(e);
				state.push(f);
				project.push(g);            
	            });
				//console.log(test);
				
				for (i=0; i<results.length; i++) {
					$("#testtable") .append('<tr>'+
					'<td>'+pbiID[i] +'</td>'+
					'<td>'+pbiTitle[i] +'</td>'+
					'<td>'+pbiDesc[i] +'</td>'+
					'<td>'+pbiEff[i] +'</td>'+
					'<td>'+priority[i] +'</td>'+
					'<td>'+state[i] +'</td>'+
					'<td class="update">update</td>'+
					'</tr>');
				};
				
/*================================================================================================================*/
/*================================================================================================================*/			
// On clicking on a Pbi show a form that has transitions to make it behave like a "pop up"
/*================================================================================================================*/
/*================================================================================================================*/
				
				// Open
				 $(".update").click(function(e) {
			         e.preventDefault();
					 var greyOut = document.getElementById('greyOut');

					 $("#greyOut").velocity("transition.fadeIn")
					 .velocity({opacity:0.9});
					 $("#popupContact").velocity("transition.bounceUpIn")
					 .velocity({opacity:1});;
				 });
				 
				 //Close
				  $("#close").click(function(e) {
			         e.preventDefault();
					 var greyOut = document.getElementById('greyOut');
					 $("#popupContact").velocity("transition.bounceDownOut");
					 $("#greyOut").velocity("transition.fadeOut",{delay:200});
					 
				 });
				
			};
		
		// bind click event to all internal page anchors	
		//$("a[href*=#]").bind("click", function(e) {
        //$("td[class=update]").bind("click", function(e) {
		// prevent default action and bubbling
        //e.preventDefault();
        //e.stopPropagation();
        // set target to anchor's "href" attribute
        //var target = $(this).attr("href");
        //});
		
			
	});	