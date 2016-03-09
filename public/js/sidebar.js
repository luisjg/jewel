$(document).ready(function(){
	
	var win = $(window);
	var winHeight = win.height()-200;
	
	var sidebar = $('#sidebar');
	sidebar.css('height',winHeight);

	var nav = $('.navbar-header');

	console.log(sidebar.position().top+' og '+nav.position().top);

	var items = $('#sidebar .item').length;

	var distance = 250;



	win.scroll(function() {
		for( x = 0; x < items; x++){
			var menuItem = $('item-'+x).position();

			//.position().top-distance;
			console.log(menuItem);
			if(menuItem < win.scrollTop()){
				// $('#sidebar a').removeClass('active');
				// $(this).find('a').addClass('active');
				console.log('Found it');
			}
		}
	});


	// Scroll on click
	jQuery('#sidebar a').on('click', function(){
		event.preventDefault();
		var menuItem = jQuery(this);
		var href = jQuery(menuItem).attr('href');
		//var target = href.substr(1);
		jQuery('#sidebar a').removeClass('active');
		menuItem.addClass('active');
		jQuery('html, body').animate({scrollTop: $(href).offset().top-distance}, 500, 'linear');
	});

	// win.scroll(function(){
	// 	if(kontakt < win.scrollTop()){
	// 		jQuery('.nav.nav-pills li').removeClass('active');
	// 		jQuery('.nav.nav-pills li.kontakt').addClass('active');
	// 	}
	// 	else if(bb < win.scrollTop()){
	// 		jQuery('.nav.nav-pills li').removeClass('active');
	// 		jQuery('.nav.nav-pills li.bestille-boker').addClass('active');
			
	// 	}
	// 	else if(forfattere < win.scrollTop()){
	// 		jQuery('.nav.nav-pills li').removeClass('active');
	// 		jQuery('.nav.nav-pills li.forfattere').addClass('active');
	// 	}
	// 	else if(boker < win.scrollTop()){
	// 		jQuery('.nav.nav-pills li').removeClass('active');
	// 		jQuery('.nav.nav-pills li.boker').addClass('active');
	// 	}
	// 	else if(hjem < win.scrollTop()) {
	// 		jQuery('.nav.nav-pills li').removeClass('active');
	// 		jQuery('.nav.nav-pills li.home').addClass('active');
	// 	}
	// });
});