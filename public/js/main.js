;(function( $ ){
	var $Nav = $(".nav" ),
	cWeb = '#000',
	$DaySceance = $('.day').find('.sceances'),
	$Overlay = $('.overlay'),
	$PopupCreer = $('.popupCreer'),
	$PopupModifier = $('.popupModifier'),
	$PopupSupprimer = $('.popupSupprimer'),
	$PopupVoir = $('.popupVoir'),
	$PopupAjouter = $('.popupAjouter'),
	$eleve = $('.elevesDuCours .eleve'),
	$actions = $('.actions'),
	$actionsPresence = $('.actionsPresence'),
	$actionsEleves = $('.actionsEleves'),
	$actionsPlanning = $('.actionsPlanning'),
	$ligne = $('.ligneSceances'),
	$popupModifierThis = $('.popupModifierThis'),
	$popupSupprimerThis = $('.popupSupprimerThis'),
	$popupSupprimerEleves = $('.popupSupprimerEleves'),
	$sceanceId,
	$slugEleve,
	$groupeEleve,
	$presenceId,
	$search = $('.search').find('#search'),
	oMyCoursColors = [],
	oMyPresenceColors = [],
	oMyGroupeColors = [],
	oColorCours,
	oColorPresence,
	oColorGroupe,
	$config = $('.config'),
	mouseX,
	mouseY;

	$(function(){ //dans config, on peut changer les couleurs, enregistrer dans un json et les recups ave un tit js
		
		//getPref();
		putColorSceances();
		putColorGroupeEleves();
		putColorGroupe();

		$.each($('.mesCours').find('.cours'),function(){
			var $type = $(this).attr('data-type');
			if($type ==="web"){ //avec les données json on boucle pour changer la couleur
				$(this).find('.titre > h3').css({
					color:cWeb,
				});
			}
		});

		if($DaySceance){
			$.each($DaySceance,function(){

				$(this).parent('.day').find('.number').css({
					color:'white',
				});
			});
		}

		/* MENU */
		$('.menuLow').on('click',openMenu);

		/* MENU */

		/* POP UP */
		$('.popupCreerCours .close').on('click','a',closePopup);
		$('.popupModifierCours .close').on('click','a',closePopup);
		$('.popupSupprimerCours .close').on('click','a',closePopup);
		$('.close').on('click','a',closePopup);
		$('.delete').on('click',closeActions);

		$('.helper a[data-link="creer"').on('click',showCreerPopup);
		$('.helper a[data-link="modifier"').on('click',showModifierPopup);
		$('.helper a[data-link="supprimer"').on('click',showSupprimerPopup);
		$('.helper a[data-link="voir"').on('click',showVoirPopup);
		$('.helper a[data-link="ajouter"').on('click',showAjouterPopup);
		/* END POP UP */

		/* COLOR */
		$('#color').change(function(){
			console.log($('#color').val());
		});
		/* END COLOR*/

		/* OVERLAY */

		$Overlay.on('click',hideAll);
		/* END OVERLAY */

		/* HELPER VOIR COURS */

		$('.helper.voirCours .groupe li').on('click','a',showEleveGroupe);
		/* END HELPER VOIR COURS */

		/* HELPER PRESENCE COURS */

		$('.helper.voirCours .presence li').on('click','a',showPresenceEleveGroupe);

		/* END HELPER PRESENCE COURS */

		/* SCEANCES */

		/* LIGNE */

		$('.sceancesMois li').on('click','a',function( e ){
			e.preventDefault();
			mouseX = e.pageX; 
			mouseY = e.pageY;
			var $id = $(this).attr('data-sceance');
			showActions($id,mouseX,mouseY);
		});

		$actions.on('click','a.modifier',showModifierThisPopup);
		$actions.on('click','a.supprimer',showSupprimerThisPopup);
		$actionsPresence.find('.present').on('click',putPresent);
		$actionsPresence.find('.justifier').on('click',putJustifier);
		$actionsPresence.find('.absent').on('click',putAbsent);
		$actionsPresence.find('.aucune').on('click',putAucune);

		/* END LIGNE */
		/* PRESENCE */
		$('.elevesDuCours.presenceCours .eleve').on('click','a',showActionsPresence);
		/* END PRESENCE */
		/* END SCEANCES */

		/* ANCRES */
		$('a[href^="#"]').click(function(){
			var the_id = $(this).attr("href");
			$('html, body').animate({
				scrollTop:$(the_id).offset().top
			}, 'slow');
			return false;
		});
		/* END ANCRES */
		/* ELEVES */
		
		$search.keydown(function(){
			setTimeout(function() {
				var $value = $search.val();
				listEleves( $value );

			}, 50);
		});
		
		$('.eleves li').on('click','a',function( e ){
			e.preventDefault();
			mouseX = e.pageX; 
			mouseY = e.pageY;
			var $slug = $(this).parent().attr('data-slug');
			showActions($slug,mouseX,mouseY);
		});
		
		
		/* END ELEVES */
		/* GROUPE */
		$('.listGroupes .groupe').on('click','a',function( e ){
			e.preventDefault();
			mouseX = e.pageX; 
			mouseY = e.pageY;
			var $id = $(this).attr('data-groupe');
			showActions($id,mouseX,mouseY);
		});

		$('.elevesGroupe .eleve').on('click','a',function( e ){
			e.preventDefault();
			mouseX = e.pageX; 
			mouseY = e.pageY;
			var $id = $(this).attr('data-groupe');
			showActionsEleves($id,mouseX,mouseY);
		});

		$actionsEleves.on('click','a.supprimer',showSupprimerThisPopup);

		$('.helper a[data-link="supprimerEleves"').on('click',showSupprimerElevesPopup);
		/* END GROUPE */
		/* CONFIG */

		displayConfig();

		$('.couleur .save').on('click',savePref);
		
		/* END CONFIG */
		/* PLANNING */
		$('.day').on('click','a',function( e ){
			e.preventDefault();
			mouseX = e.pageX; 
			mouseY = e.pageY;
			showActionsPlanning(mouseX,mouseY);
		});
		/* END PLANNING */


	});
var displayConfig = function(){

/*	displayConfigCours();
	displayConfigPresence();
	displayConfigGroupe();*/

};
/*var displayConfigCours = function(){

	for(var i = 0;i<oColorCours.length;i++){

		$config.find('.cours').append('<li><label for="color'+oColorCours[i].cours+'">'+oColorCours[i].cours.capitalize()+'</label><input type="color" value="'+oColorCours[i].color+'" name="color'+oColorCours[i].cours+'" id="color'+oColorCours[i].cours+'"></li>');
	}
};
var displayConfigGroupe = function(){

	for(var i = 0;i<oColorGroupe.length;i++){

		$config.find('.groupe').append('<li><label for="color'+oColorGroupe[i].groupe+'">'+oColorGroupe[i].groupe.capitalize()+'</label><input type="color" value="'+oColorGroupe[i].color+'" name="color'+oColorGroupe[i].groupe+'" id="color'+oColorGroupe[i].groupe+'"></li>');
	}
};
var displayConfigPresence = function(){

	for(var i = 0;i<oColorPresence.length;i++){

		$config.find('.presence').append('<li><label for="color'+oColorPresence[i].presence+'">'+oColorPresence[i].slug+'</label><input type="color" value="'+oColorPresence[i].color+'" name="color'+oColorPresence[i].presence+'" id="color'+oColorPresence[i].presence+'"></li>');
	}
};*/
var savePref = function(){
	$.each($('.config ul li'),function(){

		var key = $(this).find('label').html().toLowerCase();
		var data = $(this).find('input').val();
		savePrefAjax("color","presence",key,data);
	});
	
};
var savePrefAjax = function(what , of , key , data){
	$.ajax({
		url: "",//url/what/of/key/data
		success: function( data ) {
			console.log('ajax');
		}
	})
};
var goToEleve = function( e ){
	e.preventDefault();
	$(this).parent().parent().parent().hide();
	$slug = $(this).attr('data-slug');
	$that = $('.list .range li[data-slug="'+$slug+'"]');
	goTo($that);
	$that.find('.nom a').focus();

	
};
var goTo = function($selector){
	$('html, body').animate({
		scrollTop: $selector.offset().top
	}, 400);
};
var putColorSceances  = function(){
	$.each($('.sceances li'),function(){
		var $sceance = $(this).attr('data-cours');

		if( oMyCoursColors[$sceance]){
			$(this).css({
				backgroundColor:oMyCoursColors[$sceance],
			})
		}
	});
	

};
var putColorGroupeEleves = function(){

	$.each($('.eleves li'),function(){
		var $groupe = $(this).find('.groupe').attr('data-groupe');

		if( oMyGroupeColors[$groupe]){
			$(this).css({
				backgroundColor:oMyGroupeColors[$groupe],
				color:"white",

			});
			$(this).find('span > a').css({
				color:"white",
				borderBottom:"1px dotted white",
				borderTop:0,
			});
		}
	});
};
var putColorGroupe = function(){

	$.each($('.listGroupes .groupe'),function(){
		var $groupe = $(this).find('.nom').attr('data-groupe');

		if( oMyGroupeColors[$groupe]){

			$(this).find('a').css({
				backgroundColor:oMyGroupeColors[$groupe],
				color:"white",

			});
			$(this).find('span > a').css({
				color:"white",
				borderBottom:"1px dotted white",
				borderTop:0,
			});
		}
	});
};

var listEleves = function( value ){
	var value = value.toLowerCase();
	if($.type(value)==="string"){
		autocompleteEleves( value );
		$('.listAutocomplete li').on('click','a',goToEleve);
	}
	
};
var addNameToList = function( sNom ,sSlug ){
	var $inSide = $('.search .listAutocomplete li');
	var bExist = false;
	if($inSide.length > 0){
		$.each($inSide,function(){
			
			if($(this).find('a').attr('data-slug') === sSlug){
				bExist = true;
			}
			
		});
		if(!bExist){
			$('.search .autoCompletionEleves').show();
			$('.search .listAutocomplete').append('<li><a href="voirEleve.php" data-slug="'+sSlug+'" title="Voir la fiche de l\'élève">'+sNom+'</a></li>');
		}
	}
	else{

		if(!bExist){
			$('.search .autoCompletionEleves').show();
			$('.search .listAutocomplete').append('<li><a href="voirEleve.php" data-slug="'+sSlug+'" title="Voir la fiche de l\'élève">'+sNom+'</a></li>');
		}
	}
	
};
var removeNameToList = function( sSlug ){

	var $inSide = $('.search .listAutocomplete li');
	if(sSlug !== "all"){
		$.each($inSide,function(){
			
			if($(this).find('a').attr('data-slug') === sSlug){
				$(this).remove();
			}
			
		});
	}else{
		$inSide.remove();
	}
	
};
var autocompleteEleves = function( value ){
	if(value !== ""){
		aData = dataAutocompleteEleves();

		for(var i=0;i<aData.length;i++){

			if( aData[i].indexOf(value) >= 0){

				var sNomReplace = aData[i].replace('-'," ");
				var sNomWellDisplay = sNomReplace.ucwords();
				addNameToList(sNomWellDisplay, aData[i]);

			}
			else{
				removeNameToList( aData[i]);
			}

		}
	}
	else{
		removeNameToList( "all");
		$('.autoCompletionEleves').hide();
	}
};
var dataAutocompleteEleves = function(){
	var aDataNom = [],
	aDataAnneeLevel = [],
	aDataGroupe = [],
	aDataOption = [],
	$nom,
	$anneeLevel,
	$groupe,
	$option;

	$.each($('.range'),function(){
		$.each($('.eleves .etudiant'),function(){
			$nom = $(this).find('.nom').attr('data-slug');
			var ok = $.inArray($nom, aDataNom);
			if(ok < 0){
				aDataNom.push($nom);
			}

			$anneeLevel = $(this).find('.anneeLevel').attr('data-slug');
			var ok = $.inArray($anneeLevel, aDataAnneeLevel);
			if(ok < 0){
				aDataAnneeLevel.push($anneeLevel);
			}


			$groupe = $(this).find('.groupe').text();
			var ok = $.inArray($groupe, aDataGroupe);
			if(ok < 0){
				aDataGroupe.push($groupe);
			}


			$option = $(this).find('.option').text();
			var ok = $.inArray($option, aDataOption);
			if(ok < 0){
				aDataOption.push($option);
			}

		});
	});
	
	return aDataNom;
};

var putPresent = function( e ){
	e.preventDefault();
	//requete ajax pour changer la presence
	if(ajaxChangePresence( $slugEleve, $sceanceId, $(this).attr('data-presence'))){
		
		$that = $eleve.find('.nom[data-slug="'+$slugEleve+'"]');
		$presenceId = $(this).attr('data-presence');

		$that.css({
			color:oMyPresenceColors[$presenceId],
		});
	}
	
};
var putJustifier = function( e ){
	e.preventDefault();
	//requete ajax pour changer la presence
	if(ajaxChangePresence( $slugEleve, $sceanceId, $(this).attr('data-presence'))){
		
		$that = $eleve.find('.nom[data-slug="'+$slugEleve+'"]');
		$presenceId = $(this).attr('data-presence');

		$that.css({
			color:oMyPresenceColors[$presenceId],
		});
	}
	
};
var putAbsent = function( e ){
	e.preventDefault();
	//requete ajax pour changer la presence
	if(ajaxChangePresence( $slugEleve, $sceanceId, $(this).attr('data-presence'))){
		
		$that = $eleve.find('.nom[data-slug="'+$slugEleve+'"]');
		$presenceId = $(this).attr('data-presence');

		$that.css({
			color:oMyPresenceColors[$presenceId],
		});
	}
	
};
var putAucune = function( e ){
	e.preventDefault();
	//requete ajax pour changer la presence
	if(ajaxChangePresence( $slugEleve, $sceanceId, $(this).attr('data-presence'))){
		
		$that = $eleve.find('.nom[data-slug="'+$slugEleve+'"]');
		$presenceId = $(this).attr('data-presence');

		$that.css({
			color:oMyPresenceColors[$presenceId],
		});
	}
	
};
// var getPref= function(  ){
// 	$.ajax({
// 		async: false,
// 		url: "config.json",
// 		success: function( data ) {
// 			/*var oMyColors ={};
// 			$.each(data.color,function(key){
// 				console.log($(this));

				
// 				for(var i = 0;i <= $(this).length-1;i++){

// 					oMyColors.key[$(this)[i].cours] = $(this)[i].color;
// 				}
// 				console.log(oMyColors);

// 			});*/

// 	oColorCours = data.color.cours;
// 	oColorPresence = data.color.presence;
// 	oColorGroupe = data.color.groupe;

// 	for(var i = 0;i <= oColorCours.length-1;i++){

// 		oMyCoursColors[oColorCours[i].cours] = oColorCours[i].color;	
// 	}
// 	for(var i = 0;i <= oColorPresence.length-1;i++){

// 		oMyPresenceColors[oColorPresence[i].presence] = oColorPresence[i].color;	
// 	}
// 	for(var i = 0;i <= oColorGroupe.length-1;i++){

// 		oMyGroupeColors[oColorGroupe[i].groupe] = oColorGroupe[i].color;	
// 	}
// }
// })

	
	
// };
var ajaxChangePresence = function( $eleve, $sceance , $presence){
	/*$.ajax({
		url:"",
		dataType:"json",
		success:function( data ){
			return true;
		};
	});*/
return true;
};
var showSupprimerThisPopup = function( e ){
	e.preventDefault();
	mouseX = e.pageX; 
	mouseY = e.pageY;

	$popupSupprimerThis.css({'top':mouseY+125,'left':+130}).fadeIn();
	overlay( $popupSupprimerThis );


	$popupModifierThis.hide();
};
var showModifierThisPopup = function( e ){
	e.preventDefault();
	mouseX = e.pageX; 
	mouseY = e.pageY;

	$popupModifierThis.css({'left':0}).fadeIn();
	overlay( $popupModifierThis );


	$popupSupprimerThis.hide();
};
var showSupprimerElevePopup = function( e ){
	e.preventDefault();
	mouseX = e.pageX; 
	mouseY = e.pageY;

	$('.popupSupprimerEleves').css({'left':+130}).fadeIn();
	overlay( $popupSupprimerThis );


	$popupModifierThis.hide();
};
var showModifierElevePopup = function( e ){
	e.preventDefault();
	mouseX = e.pageX; 
	mouseY = e.pageY;

	$('.popupModifierEleves').css({'top':mouseY+125,'left':0}).fadeIn();
	overlay( $popupModifierThis );


	$popupSupprimerThis.hide();
};
var showActions = function($selector, x, y){

	$actions.attr('data-id',$selector);

	$actions.css({'top':y+25,'left':x-100}).fadeIn('fast');
	
};
var showActionsEleves = function($selector, x, y){

	$actionsEleves.attr('data-id',$selector);

	$actionsEleves.css({'top':y+25,'left':x-100}).fadeIn('fast');
	
};
var showActionsPlanning = function( x, y){


	$actionsPlanning.css({'top':y+25,'left':x-100}).fadeIn('fast');
	
};
var showActionsPresence = function( e ){
	e.preventDefault();
	mouseX = e.pageX; 
	mouseY = e.pageY;

	$slugEleve = $(this).find('.nom').attr('data-slug');
	$groupeEleve = $(this).find('.groupe').attr('data-groupe');
	$sceanceId = Number($('.gererMaSceance').attr('data-sceance'));
	$actionsPresence.css({'top':mouseY+50,'left':mouseX}).fadeIn('fast');
	
};
var showPresenceEleveGroupe = function( e ){
	e.preventDefault();
	if($(this).attr('data-link') === 'presence'){
		$(this).attr('data-link','image');
		$(this).html('Revoir les photos');

		$('.presenceGroupe').fadeIn();
		
		$.each($eleve,function(){
			$(this).find('img').hide();

			$(this).find('.percent span').html('70%');
			$(this).find('.percent').show();

		});
	}
	else
	{
		$(this).attr('data-link','presence');
		$(this).html('Voir les présences');

		$('.presenceGroupe').fadeOut();
		
		$.each($eleve,function(){
			$(this).find('.percent').hide();	
			$(this).find('img').show();
		});
	}
};
var showEleveGroupe = function( e ){
	e.preventDefault();

	$('.helper.voirCours .groupe li.active').removeClass('active');
	$(this).parent().addClass('active');

	$('.helper.voirCours .presence li > a').attr('data-groupe',$(this).attr('data-groupe'));

	if($(this).attr('data-link') === 'tri'){
		if($(this).attr('data-groupe') !== 'all'){
			var $groupe = $(this).attr('data-groupe');
			var $this = $(this);
			$.each($eleve,function(){

				if($(this).find('.groupe').attr('data-groupe') !== $groupe){

					$(this).fadeOut();
				}
				else{

					$(this).fadeIn();
				}
			});
		}
		else{
			$.each($eleve,function(){
				$(this).fadeIn();
			});
		}
	}
};
var hideAll = function( e ){
	e.preventDefault();
	$Overlay.fadeOut();
	$actions.fadeOut();
	$actionsPresence.fadeOut();
	$actionsEleves.fadeOut();

	$popupModifierThis.fadeOut();
	$popupSupprimerThis.fadeOut();
	$PopupCreer.fadeOut();
	$popupSupprimerEleves.fadeOut();
	$PopupModifier.fadeOut();
	$PopupSupprimer.fadeOut();
	$PopupVoir.fadeOut();
	$PopupAjouter.fadeOut();
};
var overlay = function( $Selector ){
	$('html, body').animate({
		scrollTop: $Selector.offset().top
	}, 800,function(){
		$Overlay.css({
			height:$(window).height(),
			width:$(window).width(),
			display:"block",
		});
	});
};
var showCreerPopup = function( e ){
	e.preventDefault();
	$PopupCreer.fadeIn();
	overlay( $PopupCreer );


	$PopupModifier.hide();
	$PopupSupprimer.hide();
	$popupSupprimerEleves.hide();
	$PopupVoir.hide();
	$PopupAjouter.hide();

};

var showModifierPopup = function( e ){
	e.preventDefault();
	$PopupModifier.fadeIn();
	overlay( $PopupModifier );

	$PopupCreer.hide();
	$popupSupprimerEleves.hide();
	$PopupSupprimer.hide();
	$PopupVoir.hide();
	$PopupAjouter.hide();
};
var showSupprimerPopup = function( e ){
	e.preventDefault();
	$PopupSupprimer.fadeIn();
	overlay( $PopupSupprimer );

	$PopupModifier.hide();
	$popupSupprimerEleves.hide();
	$PopupCreer.hide();
	$PopupVoir.hide();
	$PopupAjouter.hide();
};
var showVoirPopup = function( e ){
	e.preventDefault();
	$PopupVoir.fadeIn();
	overlay( $PopupVoir );

	$PopupModifier.hide();
	$popupSupprimerEleves.hide();
	$PopupSupprimer.hide();
	$PopupCreer.hide();
	$PopupAjouter.hide();
};
var showAjouterPopup = function( e ){
	e.preventDefault();
	$PopupAjouter.fadeIn();
	overlay( $PopupAjouter );

	$PopupModifier.hide();
	$popupSupprimerEleves.hide();
	$PopupSupprimer.hide();
	$PopupCreer.hide();
	$PopupVoir.hide();
};
var showSupprimerElevesPopup = function( e ){
	e.preventDefault();
	$popupSupprimerEleves.fadeIn();
	overlay( $PopupAjouter );

	$PopupModifier.hide();
	$PopupSupprimer.hide();
	$PopupCreer.hide();
	$PopupVoir.hide();
	$PopupSupprimer.hide();
};
var openMenu = function( e ){
	e.preventDefault();
	var $this = $(this).parent('.wrapper').find('.menu');
	$this.slideToggle().css({
		boxShadow:'rgba(0,0,0,0.4) 0 3px 3px 0',
		'-webkit-boxShadow':'rgba(0,0,0,0.4) 0 3px 3px 0',
		backgroundColor: '#5097bd',
	});
};
var closePopup = function( e ){
	e.preventDefault();
	$(this).parent().parent().fadeOut('fast');
	$Overlay.fadeOut();
	$actions.fadeOut();
};
var closeActions = function( e ){
	e.preventDefault();
	$(this).parent().fadeOut();
};

String.prototype.ucwords = function() {
	var words = this.split(' '),
	i = 0,
	l = words.length;
	for( ; i < l; i++) {
		words[i] = words[i].charAt(0).toUpperCase() + 
		words[i].slice(1);
	}
	return(words.join(' '));
};
String.prototype.capitalize = function() {
	return this.charAt(0).toUpperCase() + this.slice(1);
}

}).call(this,jQuery);