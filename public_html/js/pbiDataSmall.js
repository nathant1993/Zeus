/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to return PBI data
/*================================================================================================================*/
/*================================================================================================================*/

$(document).ready(function() {
	        $.ajax({
	            dataType: "json",
	            url: "../php/PBIData.php",
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
					'</tr>');
				};				
				
			};
			
	});	