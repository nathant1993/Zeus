$(document).ready(function() {
	        $.ajax({
	            dataType: "json",
	            url: "./php/PBIData.php",
				success: function createArray (pbis) {
                    PBI(pbis);
                    console.log(pbis);
				}            
	        });
			
			function PBI(results){};
	});	