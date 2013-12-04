
;(function( $ ){

	$(function(){

		$('#jourX').on('change',addDayForm);
	});
	var addDayForm = function (  ){
		console.log($(this).find('selected').val());
	}

}).call(this,jQuery);