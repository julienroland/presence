
;(function( $ ){

	$(function(){

		$('#jourX').on('change',addDayForm);

		$('.presenceChoice li>a').on('click',function( e ){
			e.preventDefault();

			var nIdPresence = $(this).attr('data-idpresence');
			var nIdEleve = $(this).attr('data-ideleve');
			var nIdSceance = $(this).attr('data-idsceance');

			ajaxModifierPresence( nIdPresence, nIdEleve, nIdSceance );
		})
	});
	var addDayForm = function (  ){
		console.log($(this).find('selected').val());
	}

	var ajaxModifierPresence = function( nIdPresence, nIdEleve, nIdSceance ){
		$.ajax({
			dataType: "json",
			url:"../gererPresence/modifier/"+nIdPresence+"/"+nIdEleve+"/"+nIdSceance,
			success: function ( oResponse ){

				if( oResponse.presenceId == 0 )
				{
					$('.eleve.'+oResponse.eleveId)
					.parent('.presence')
					.removeClass()
					.addClass('presence notDone '+oResponse.presenceId);
				}
				else if( oResponse.presenceId == 3 )
				{
					$('.eleve.'+oResponse.eleveId)
					.parent('.presence')
					.removeClass()
					.addClass('presence ok '+oResponse.presenceId);
				}
				else
				{
					$('.eleve.'+oResponse.eleveId)
					.parent('.presence')
					.removeClass()
					.addClass('presence notOk '+oResponse.presenceId);
				}

				ajaxUpdatePresenceTotalPourcentage( nIdSceance );
				ajaxUpdateGroupePercentage( nIdSceance );
			}
		})

	}
	var ajaxUpdatePresenceTotalPourcentage = function( nIdSceance ){
		
		$.ajax({
			dataType:"json",
			url:"../gererPresence/updateTotal/"+nIdSceance,
			success: function( oResponse ){

				$('#sceanceData').html(oResponse+" de présence");

			}
		})
	}
	var ajaxUpdateGroupePercentage = function ( nIdSceance ){

		$.ajax({
			dataType:"json",
			url:"../gererPresence/updateGroupe/"+nIdSceance,
			success: function( oResponse ){
				
				console.log(oResponse);
				for(var i = 0 ; i<=oResponse.length-1;i++){

					console.log($('.groupePresence').attr('data-groupeId'));
					//TODO si les ID des groupes matches bien
					// on peut changer les valeurs des percentages
				
				}
			}
		})
	}

}).call(this,jQuery);