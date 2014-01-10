;(function( $ ){
//couleur des cours
var myColors = [],	
myData = {},
part = {},
radius = 150,
canvas = document.getElementById("graphPresenceTotalCours"),
ctx = canvas.getContext("2d");


$(function(){
	getColors();
	plotData();
});


var getTotal = function(){
	var myTotal = 0;
	for (var j = 0; j < Object.keys(myData).length; j++) {
		myTotal += (typeof myData[j] == 'number') ? myData[j] : 0;
	}
	
	return myTotal;
}
var getColors = function(  ){
	$.ajax({
		async: false,
		url: "config.json",
		success: function( data ) {
			oColorData = data.color.cours;

			for(var i = 0;i <= oColorData.length-1;i++){

				myColors[oColorData[i].cours] = oColorData[i].color;	
			}
		}
	})

	
	
}
var plotData = function() {
	ctx,
	lastend = 0,
	total = 100,
	offset = Math.PI / 2;

	$data = $('.graphPresenceTotalCours .dataGraph li');
	
	var i = 0;
	$.each($data,function(){
		myData[i] = {
			'percent':Number($(this).attr('data-percent')),
			'cours':$(this).attr('data-cours'),
		};
		i++
	});
	var myTotal = getTotal();


	var totalCours = 0;

	var width = canvas.width - (canvas.width - (radius * 2)-50);
	var height = canvas.height;
	ctx.clearRect(0, 0, width, height);

	//CIRCLE

	ctx.fillStyle = "#CCC";
	ctx.beginPath();
	ctx.arc(width/2,height/2,radius,0 ,2 * Math.PI,false);
	ctx.fill();
	for (var i = 0; i < Object.keys(myData).length ; i++) {

		//GRAPH
		ctx.fillStyle = myColors[myData[i].cours];
		ctx.beginPath();
		ctx.moveTo(width/2,height/2);
		var arcsector = Math.PI * (2 * myData[i].percent / total);
		ctx.arc(width/2,height/2,radius,lastend ,lastend+arcsector,false);
		ctx.lineTo(width/2,height/2);
		ctx.fill();
		ctx.closePath();
		//CUBE OF GRAPH

		lastend += arcsector;
		ctx.beginPath();
		ctx.fillStyle = myColors[myData[i].cours];
		ctx.rect(width,height/height + (i * 40),20,20);
		ctx.fill();
		ctx.stroke();
		ctx.closePath();

		//TEXT OF GRAPH 
		ctx.font = "18pt palatino, 'palatino lt std', 'palatino linotype', 'book antiqua', garamond, serif";
		ctx.fillStyle = "rgb(0,0,0)";
		ctx.fillText(myData[i].cours+" ("+myData[i].percent+"%)", width+30, (height/height)+(i * 40)+20);
		
		/*part[i] = {'radius':radius,'arcsector':arcsector};*/
	}


}
	
}).call(this,jQuery);