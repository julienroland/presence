
;(function( $ ){

	$(function(){

		$('#jourX').on('change',addDayForm);
		$('.presence').on('click',TakePresence);
	});
	var addDayForm = function (  ){
		console.log($(this).find('selected').val());
	}

	var TakePresence = function(  ){

		console.log($(this).find('span').attr('class'));
		
		nEleveId = $(this).find('span').attr('class');
	}
}).call(this,jQuery);