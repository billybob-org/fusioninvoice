/* Author: William G. Rivera*/

$(document).ready(function() {
    $(".dropdown-toggle").click(function(e) {
    	var menu = $(this).next('.dropdown-menu'),
        	mousex = e.pageX + 20, //Get X coodrinates
        	mousey = e.pageY + 20, //Get Y coordinates
        	menuWidth = menu.width(), //Find width of tooltip
        	menuHeight = menu.height(), //Find height of tooltip
            menuVisX = $(window).width() - (mousex + menuWidth), //Distance of element from the right edge of viewport
        	menuVisY = $(window).height() - (mousey + menuHeight); //Distance of element from the bottom of viewport

        if (menuVisX < 20) { //If tooltip exceeds the X coordinate of viewport
            // menu.css({'left': '-89px'});
        } if (menuVisY < 20) { //If tooltip exceeds the Y coordinate of viewport
            menu.css({
            	'top': 'auto',
            	'bottom': '100%',
            });
        }
	});
	$('html').click(function () {
		$('.dropdown-menu').removeAttr('style'); //Integrate this into the function. Try finding only the element is open and not all dropdown menus
    });
});