$(document).ready(function(){
	
	var win = $(window);
	var winHeight = win.height()-200;
	
	var sidebar = $('#sidebar');
	sidebar.css('height',winHeight);

	var nav = $('.navbar-header');


	var items = $('.types');

	var distance = 250;
	var lastScrollTop = 0;

	

		// var sidebarTop = $('#sidebar').position().top;
		// var lastScrollTop = 0;
		// win.scroll(function () {
		// 	var st = $(this).scrollTop();
		// 		if( sidebarTop > 0){
		// 			if (st > lastScrollTop) {
		// 			    $('#sidebar').animate({top: '-=5'}, 5);
		// 			    console.log(sidebarTop);
		// 			} else {
		// 			    $('#sidebar').animate({top: '+=5'}, 5);
		// 			}
		// 		}
		// 	lastScrollTop = st;
		// })



	// Scroll on click
	$('#sidebar a').on('click', function(){
		event.preventDefault();
		var menuItem = $(this);
		var href = $(menuItem).attr('href');
		$('#sidebar a').removeClass('active');
		menuItem.addClass('active');
		$('html, body').animate({scrollTop: $(href).offset().top-distance}, 500, 'linear');
	});

});