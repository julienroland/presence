
;(function( $ ){

	$(function(){

		$('.menuCrud.hasForm a').on('click',showFormCours);
	});

	var showFormCours = function( e ){
		e.preventDefault();
		$(this).parent().parent().find('.formCours').slideToggle('fast');
	};

}).call(this,jQuery);