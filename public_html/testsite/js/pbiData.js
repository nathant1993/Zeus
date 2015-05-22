$(document).ready(function() {
	        $.ajax({
	            dataType: "json",
	            url: "./php/PBIData.php",
				success: function createArray (pbis) {
                    PBI(pbis);
                    console.log(pbis);
				}            
	        });
			
			/*function PBI(results){
				var cList = $('ul.mylist')
				$.each(results, function(i)
				{
				    var li = $('<li/>')
				        .addClass('ui-menu-item')
				        .attr('role', 'menuitem')
				        .appendTo(cList)
						.text(results[i]);
						
						$.each(phpArray, function (key, value) {
					    var label = value.itName;
		                xlab.push(label);                
			            });
				});
			};*/
			
			/*function PBI(tableData) {
			  var table = document.createElement('table'), 
			  tableBody = document.createElement('tbody');
			
			  tableData.forEach(function(rowData) {
			    var row = document.createElement('tr');
			
			    rowData.forEach(function(cellData) {
			      var cell = document.createElement('td');
			      cell.appendChild(document.createTextNode(cellData));
			      row.appendChild(cell);
			    });
			
			    tableBody.appendChild(row);
			  });
			
			  table.appendChild(tableBody);
			  document.body.appendChild(table);
			}
			
			PBI([["row 1, cell 1", "row 2, cell 2"], ["row 2, cell 1", "row 2, cell 2"]]);*/
			function PBI(results){
				var string = $('html').attr('class');
				//var array = string.split(' ');
				var array = results;
				var arrayLength = parseInt(array.length);
				
				for (i=0; i<=arrayLength; i++) {
				  $("#test table") .append('<tr><td>'+array[i]+'</td></tr>') 
				}
			};
	});	