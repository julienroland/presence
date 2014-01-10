;(function( $ ){
	var data = {},
	sMyColors,
	$cours = $('.dataGraph').attr('data-cours'),
	graphCanvas = document.getElementById('graphPresenceCours');
	$(function(){
		
		getColors();
		graph();

	});

	function graph() {		

		
			// Ensure that the element is available within the DOM
			if (graphCanvas && graphCanvas.getContext) {
				// Open a 2D context within the canvas
				var context = graphCanvas.getContext('2d');

				// Bar chart data
				$dataList = $('.dataGraph').find('li');

				var i= 0;

				$.each($dataList,function(){

					data[i] = {
						'percent':Number($(this).attr('data-percent')),
						'sceance':$(this).attr('data-sceance'),
					};
					i++;
				});
					
				// Draw the bar chart
				drawBarChart(context, data, 50, 100, (graphCanvas.height - 20), 10);
			}
		}
		
		// drawBarChart - draws a bar chart with the specified data
		function drawBarChart(context, data, startX, barWidth, chartHeight, markDataIncrementsIn) {
			// Draw the x and y axes
			context.lineWidth = "1.0";
			var startY = chartHeight; //380
			drawLine(context, startX, startY, startX, chartHeight/chartHeight); //30
			drawLine(context, startX, startY, graphCanvas.width, startY);	//490		
			context.lineWidth = "0.0";
			var maxValue = 0;
			
			for (var i=0; i<Object.keys(data).length; i++) {

				// Extract the data
				//var values = data[i].split(",");
				var name = data[i].sceance;
				var height = (parseInt(data[i].percent)/100) * chartHeight;
				if (parseInt(height) > parseInt(maxValue))
				{
					maxValue = height;
				}
				// Write data to chart
				context.fillStyle = "#b90000";

				drawRectangle(context, startX + (i * barWidth) + i, (chartHeight - height), barWidth, height, true);
				// Add the column title to the x-axis
				context.font = "15pt palatino, 'palatino lt std', 'palatino linotype', 'book antiqua', garamond, serif";
				context.textAlign = "left";
				context.fillStyle = "#000";
				context.fillText(name, startX + (i * barWidth) + i, chartHeight + 20, 200);				
				//Text on each bars
				//context.fillText('Pourcentage',(startX-10),chartHeight/chartHeight);	
			}	
			// Add some data markers to the y-axis
			var numMarkers = Math.ceil(((maxValue/chartHeight) * 100)/ markDataIncrementsIn);
			context.textAlign = "right";
			context.fillStyle = "#000";
			var markerValue = 0;
			for (var i=0; i<numMarkers; i++) {		
				context.fillText(markerValue+"%", (startX - 10), (chartHeight - ((markerValue/100)*chartHeight)), 50);
				markerValue += markDataIncrementsIn;
			}		
		}
		// drawRectanle - draws a rectangle on a canvas context using the dimensions specified
		function drawRectangle(contextO, x, y, w, h, fill) {		
			contextO.beginPath();
			contextO.rect(x, y, w, h);
			contextO.closePath();
			contextO.stroke();
			contextO.fillStyle = sMyColors;
			if (fill) contextO.fill();
		}	
		// drawLine - draws a line on a canvas context from the start point to the end point 
		function drawLine(contextO, startx, starty, endx, endy) {
			contextO.beginPath();
			contextO.moveTo(startx, starty);
			contextO.lineTo(endx, endy);
			contextO.closePath();
			contextO.stroke();
		}
		var getColors = function(  ){
			$.ajax({
				async: false,
				url: "config.json",
				success: function( data ) {
					oColorData = data.color.cours;

					for(var i = 0;i <= oColorData.length-1;i++){
						if(oColorData[i].cours == $cours){

							sMyColors = oColorData[i].color
						}
						
					}
				}
			});

		}
		


	}).call(this,jQuery);