
;(function( $ ){

	$(function(){

		$('#jourX').on('change',addDayForm);

		$('.presenceChoice li>a').on('click',function( e ){
			e.preventDefault();

			var nIdPresence = $(this).attr('data-idpresence');
			var nIdEleve = $(this).attr('data-ideleve');
			var nIdSceance = $(this).attr('data-idsceance');

			ajaxModifier( nIdPresence, nIdEleve, nIdSceance );
		})
	});
	var addDayForm = function (  ){
		console.log($(this).find('selected').val());
	}

	var ajaxModifier = function( nIdPresence, nIdEleve, nIdSceance ){
		$.ajax({
			dataType: "json",
			url:"../gererPresence/modifier/"+nIdPresence+"/"+nIdEleve+"/"+nIdSceance,
			success: function ( oResponse ){
				
				console.log(oResponse);

				$('#presence').html(JSON.stringify(oResponse));

				console.log($('.eleve.'+oResponse.eleveId).parent('.presence').removeClass().addClass('presence '+oResponse.presenceId));
				
					
				
			}
		})

	}
}).call(this,jQuery);