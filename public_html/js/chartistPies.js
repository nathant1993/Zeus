/// <reference path="../js/jquery.d.ts"/>
/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to create the Chartist Pie Charts
/*================================================================================================================*/
/*================================================================================================================*/

        // on document run an AJAX call to retrieve Graph data
    //     $(document).ready(function() {
	//         $.ajax({
	//             dataType: "json",
	//             url: "./php/GraphData.php",
    //             //if the ajax call is successful run the function createarray - 
    //             //this contains everything else in this JS file
	// 			success: function createArray (result) {
    //                 createGraph(result);
    //                 //console.log(result);
	// 			}            
	//         });
	// });		
        
/*================================================================================================================*/
/*================================================================================================================*/
//This function gets called on the success callback of the AJAX call
/*================================================================================================================*/
/*================================================================================================================*/	  
	    // function createGraph(phpArray) {
            
        //     var xlab = [];
        //     var totalEffort = []; 
        //     var remainingEffort = [];
        //     var effortcommitted =[];
        //     var noOfSprints = 0;
            
        //     //Get each iteration name out of the JSON array
	    //     $.each(phpArray, function (key, value) {
		// 	    var label = value.itName;
        //         xlab.push(label); 
        //         noOfSprints++ ;               
	    //         });
        //         //console.log(xlab);
           
        //    //get each iteration effort total from the JSON array and check for nulls.
        //    //nulls will skew graph data 
        //    $.each(phpArray, function (key, value) {
        //        if (!value.effTot) {   
        //        }
        //        else{
        //            var tEff = value.effTot;
        //             totalEffort.push(tEff);
        //         }                   
	    //         });
        //         //console.log(totalEffort);
                
        //    //get each iteration effort remaining from the JSON array and check for nulls.
        //    //nulls will skew graph data     
        //    $.each(phpArray, function (key, value) {
        //        if (!value.effRem) {   
        //        }
        //        else{
    	// 		    var rEff = value.effRem;
        //             remainingEffort.push(rEff);
        //        }                
	    //        });
        //         //console.log(remainingEffort);
            
        //     //get each iteration effort done from the JSON array.
        //     $.each(phpArray, function (key, value) {
        //         var comeff = value.effCom;
        //         effortcommitted.push(comeff);                
	    //         });
        //          //console.log(effortcommitted);
        //          //console.log(noOfSprints);
/*================================================================================================================*/
/*================================================================================================================*/
//Create the left hand pie chart
/*================================================================================================================*/
/*================================================================================================================*/
$(document).ready(function() {
  for (i=1;i<=3;i++){           
  var chart = new Chartist.Pie('#pieContainer'+i, {
  series: [75,25],
  labels: [1, 2]
}, {
  donut: true,
  donutWidth : 45,
  showLabel: false
});

chart.on('draw', function(data) {
  if(data.type === 'slice') {
    // Get the total path length in order to use for dash array animation
    var pathLength = data.element._node.getTotalLength();

    // Set a dasharray that matches the path length as prerequisite to animate dashoffset
    data.element.attr({
      'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
    });

    // Create animation definition while also assigning an ID to the animation for later sync usage
    var animationDefinition = {
      'stroke-dashoffset': {
        id: 'anim' + data.index,
        dur: 1000,
        from: -pathLength + 'px',
        to:  '0px',
        easing: Chartist.Svg.Easing.easeOutQuint,
        // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
        fill: 'freeze'
      }
    };

    // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
    if(data.index !== 0) {
      animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
    }

    // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us
    data.element.attr({
      'stroke-dashoffset': -pathLength + 'px'
    });

    // We can't use guided mode as the animations need to rely on setting begin manually
    // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
    data.element.animate(animationDefinition, false);
  }
});

// For the sake of the example we update the chart every time it's created with a delay of 8 seconds
// chart.on('created', function() {
//   if(window.__anim21278907124) {
//     clearTimeout(window.__anim21278907124);
//     window.__anim21278907124 = null;
//   }
//   window.__anim21278907124 = setTimeout(chart.update.bind(chart), 10000);
// });
  }
});