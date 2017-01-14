/// <reference path="../js/jquery.d.ts"/>
/*================================================================================================================*/
/*================================================================================================================*/
// JavaScript to create the Chartist graphs
/*================================================================================================================*/
/*================================================================================================================*/

        // on document run an AJAX call to retrieve Graph data
        $(document).ready(function() {
	        $.ajax({
	            dataType: "json",
	            url: "./php/GraphData.php",
                //if the ajax call is successful run the function createarray - 
                //this contains everything else in this JS file
				success: function createArray (result) {
                    createGraph(result);
                    //console.log(result);
				}            
	        });
	});		
        
/*================================================================================================================*/
/*================================================================================================================*/
//This function gets called on the success callback of the AJAX call
/*================================================================================================================*/
/*================================================================================================================*/	  
	    function createGraph(phpArray) {
            
            var xlab = [];
            var xlabBar = [];
            var totalEffort = []; 
            var remainingEffort = [];
            var effortcommitted =[];
            var noOfSprints = 0;
            
            //Get each iteration name out of the JSON array
	        $.each(phpArray, function (key, value) {
			    var label = value.itName;
                xlab.push(label); 
                xlabBar.push(label);
                noOfSprints++ ;               
	            });
                //console.log(xlab);
           
           //get each iteration effort total from the JSON array and check for nulls.
           //nulls will skew graph data 
           $.each(phpArray, function (key, value) {
               if (!value.effTot) {   
               }
               else{
                   var tEff = value.effTot;
                    totalEffort.push(tEff);
                }                   
	            });
                //console.log(totalEffort);
                
           //get each iteration effort remaining from the JSON array and check for nulls.
           //nulls will skew graph data     
           $.each(phpArray, function (key, value) {
               if (!value.effRem) {   
               }
               else{
    			    var rEff = value.effRem;
                    remainingEffort.push(rEff);
               }                
	           });
                //console.log(remainingEffort);
            
            //get each iteration effort done from the JSON array.
            $.each(phpArray, function (key, value) {
                var comeff = value.effCom;
                effortcommitted.push(comeff);                
	            });
                 //console.log(effortcommitted);
                 //console.log(noOfSprints);
/*================================================================================================================*/
/*================================================================================================================*/
//Create the line graph
/*================================================================================================================*/
/*================================================================================================================*/
                   
	        var data = {
	            // A labels array that can contain any sort of values
                labels: xlab,
	            // Our series' array that contains series objects or in this case series data arrays
	            series: [
                  totalEffort,
                  remainingEffort
	            ]
	        };

	        // As options we currently only set a static size of 300x200 px. We can also omit this and use aspect ratio containers
	        // as you saw in the previous example
	        var options = {
	            low: 0,
                //onlyInteger: true
                axisY: {
                    onlyInteger: true
                }
	        };
            
            //options to use when with smaller screens    
	        var responsiveOptions = [
              ['screen and (min-width: 501px) and (max-width: 1024px)', {
                  //showPoint: false,
                  axisX: {
                      labelInterpolationFnc: function (value) {
                          // Will return just the sprint number on medium screens
                          //return value.slice(0, 3);
                          //find the position of the last instance of a t in the x axis label
                          var tInString = value.lastIndexOf('t');
                          
                          //find the position of the end of the string - this is important once we get into double figures
                          var endofString = value.length;
                          
                          //return the slice of the x axis label between the 't' of sprint and the end of the string
                          var sprintNo = value.slice(tInString+1,endofString); 
                          return sprintNo;
                      }
                  }
              }],
              
              ['screen and (max-width: 500px)', {
                  //showPoint: false,
                  axisX: {
                      labelInterpolationFnc: function (value) {
                          // Will return just the sprint number on small screens
                          //return value[0];
                          //this code is the same as the above.
                          var tInString = value.lastIndexOf('t');
                          var endofString = value.length;
                          var sprintNo = value.slice(tInString+1,endofString);
                          return sprintNo;
                      }
                  }
              }]
	        ];
            
            //options to use when with smaller screens    
	        var responsiveOptionsForMoreThanTenSprints = [
              ['screen and (min-width: 501px) and (max-width: 5000px)', {
                  //showPoint: false,
                  axisX: {
                      labelInterpolationFnc: function (value) {
                          // Will return just the sprint number on medium screens
                          //return value.slice(0, 3);
                          //find the position of the last instance of a t in the x axis label
                          var tInString = value.lastIndexOf('t');
                          
                          //find the position of the end of the string - this is important once we get into double figures
                          var endofString = value.length;
                          
                          //return the slice of the x axis label between the 't' of sprint and the end of the string
                          var sprintNo = 'S ' + value.slice(tInString+1,endofString); 
                          return sprintNo;
                      }
                  }
              }],
              
              ['screen and (max-width: 500px)', {
                  //showPoint: false,
                  axisX: {
                      labelInterpolationFnc: function (value) {
                          // Will return just the sprint number on small screens
                          //return value[0];
                          //this code is the same as the above.
                          var tInString = value.lastIndexOf('t');
                          var endofString = value.length;
                          var sprintNo = value.slice(tInString+1,endofString);
                          return sprintNo;
                      }
                  }
              }]
	        ];
            
            //create the burndown line graph
            //find out how many labels there are on the x-axis, if there are more than 10 use a different set of options to create the graph
            if(noOfSprints >10){
                var chart = new Chartist.Line('#chart1', data, options, responsiveOptionsForMoreThanTenSprints);
            }
            else{
                var chart = new Chartist.Line('#chart1', data, options, responsiveOptions);
            }
	        
	        var seq = 0,
            delays = 10,
            durations = 1500;

	        // Once the chart is fully created we reset the sequence
	        chart.on('created', function () {
	            seq = 0;
	        });

	        // On each drawn element by Chartist we use the Chartist.Svg API to trigger SMIL animations
	        chart.on('draw', function (data) {
	            seq++;

	            if (data.type === 'line') {
	                // If the drawn element is a line we do a simple opacity fade in. This could also be achieved using CSS3 animations.
	                data.element.animate({
	                    opacity: {
	                        // The delay when we like to start the animation
	                        begin: seq * delays + 1000,
	                        // Duration of the animation
	                        dur: durations,
	                        // The value where the animation should start
	                        from: 0,
	                        // The value where it should end
	                        to: 1
	                    }
	                });
	            } else if (data.type === 'label' && data.axis === 'x') {
	                data.element.animate({
	                    y: {
	                        begin: seq * delays,
	                        dur: durations,
	                        from: data.y + 100,
	                        to: data.y,
	                        // We can specify an easing function from Chartist.Svg.Easing
	                        easing: 'easeOutQuart'
	                    }
	                });
	            } else if (data.type === 'label' && data.axis === 'y') {
	                data.element.animate({
	                    x: {
	                        begin: seq * delays,
	                        dur: durations,
	                        from: data.x - 50,
	                        to: data.x,
	                        easing: 'easeOutQuart'
	                    }
	                });
	            } else if (data.type === 'point') {
	                data.element.animate({
	                    x1: {
	                        begin: seq * delays,
	                        dur: durations,
	                        from: data.x - 50,
	                        to: data.x,
	                        easing: 'easeOutQuart'
	                    },
	                    x2: {
	                        begin: seq * delays,
	                        dur: durations,
	                        from: data.x - 50,
	                        to: data.x,
	                        easing: 'easeOutQuart'
	                    },
	                    opacity: {
	                        begin: seq * delays,
	                        dur: durations,
	                        from: 0,
	                        to: 1,
	                        easing: 'easeOutQuart'
	                    }
	                });
	            } 
	        });
/*================================================================================================================*/
/*================================================================================================================*/
//Add a tooltip to the Graph and make points clickable so that they take you to clicked sprint on the sprints page
/*================================================================================================================*/
/*================================================================================================================*/           

           //this can be a class instead of an ID but we don't need it on all graphs. 
            var $chart = $('#chart1');
            
            // Add classes to the tooltip
            var $toolTip = $chart
              .append('<div class="tooltip"></div>')
              .find('.tooltip')
              .hide();
            
            //when the mouse enters the point on the chart  show the tooltip
            $chart.on('mouseenter', '.ct-point', function() {
              var $point = $(this),
                value = $point.attr('ct:value')
                //if the line is the top line it will have a class ending in a therefore we know we can rename this to total effort
                //and make the border colour correspond to the colour of the line
                if ($point.parent().attr('class')=='ct-series ct-series-a'){
                    seriesName = 'Total Effort';
                    $toolTip.css("border","1px solid #4eabec")            
                }
                //very similar to the above the 2nd line's class ends in b therefore we can rename this to remaining effort
                //and make the border colour correspond to the colour of the line
                else if ($point.parent().attr('class')=='ct-series ct-series-b') {
                    seriesName = 'Remaining Effort';
                    $toolTip.css("border","1px solid #ec704e")
                } 
                //if neither of these are present then fall back to the word effort
                else {
                    seriesName = 'Effort';
                }
              $toolTip.html(seriesName + '<br>' + value).show();
              
              //make graph points clickable and link through to the correct sprint on the sprints page
              $point.click(function(e){
                var value = $point.attr('ct:value')
                var arrayPosition = remainingEffort.indexOf(value)
                var relatedSprintNo = xlab[arrayPosition]
                //console.log(relatedSprintNo);
                //console.log("./dashboard/sprints.php?" + relatedSprintNo);
                location = "./dashboard/sprints.php?SprintNo=" + relatedSprintNo.trim()
              })
            });
            
            //when the mouse leaves the dot on the graph hide the tooltip
            $chart.on('mouseleave', '.ct-point', function() {
              $toolTip.hide();
            });
            
            //track  the mouse's location as it moves around the chart area and apply it's coordinates to the css of the tooltip so it moves with the mouse.
            $chart.on('mousemove', function(event) {
              $toolTip.css({
                left: (event.offsetX || event.originalEvent.layerX) - $toolTip.width() / 2 - 10,
                top: (event.offsetY || event.originalEvent.layerY) - $toolTip.height() - 40
                  //  left:220,
                  //  top:35                   
              });
            });
            
            // $('.ct-point').click(function(e){
            //     value = $point.attr('ct:value')
            //     console.log(value);    
              
            //     var arrayPosition = remainingEffort.indexOf(value)
            //     console.log(arrayPosition);
            //   })
/*================================================================================================================*/
/*================================================================================================================*/
// Create the Bar Chart
/*================================================================================================================*/
/*================================================================================================================*/
            
            //create the bar chart for effort done per sprint
            //find out how many labels there are on the x-axis, if there are more than 10 use a different set of options to create the graph

                var barchart = new Chartist.Bar('#chart2', {
                    labels: xlabBar.splice(xlabBar.length -6, 6),
                    series: [effortcommitted.splice(effortcommitted.length -6, 6)]
                },
                options,
                responsiveOptionsForMoreThanTenSprints);  

	        // Once the chart is fully created we reset the sequence
	        barchart.on('created', function () {
	            seq = 0;
	        });

	        // On each drawn element by Chartist we use the Chartist.Svg API to trigger SMIL animations
	        barchart.on('draw', function (data) {
	            seq++;

	            if (data.type === 'bar') {
	                // If the drawn element is a bar we do a simple opacity fade in. This could also be achieved using CSS3 animations.
	                data.element.animate({
	                    opacity: {
	                        // The delay when we like to start the animation
	                        begin: seq * delays,
	                        // Duration of the animation
	                        dur: 1000,
	                        // The value where the animation should start
	                        from: 0,
	                        // The value where it should end
	                        to: 1
	                    },
                        /*y1: {
	                        begin: seq * delays,
	                        dur: durations,
	                        from: data.y -10,
	                        to: data.y,
	                        easing: 'easeOutQuart'
	                    }*/
	                });
	            }
                });
	    };