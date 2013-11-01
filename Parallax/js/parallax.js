;(function($){

    $.fn.parallax = function(config){

    	var defaults = {
    			minWidth: 1024, //Minimum Screen Width
                developerMode: false
            },
        	options = $.extend({}, defaults, config),
        	windowWidth = $(window).innerWidth();

        if(windowWidth > options.minWidth){
	        $(this).each(function(){
		        var item = $(this),
		        	speed = item.attr('data-speed');
		        $(window).scroll(function() {
		            var yPos = -($(window).scrollTop() / speed),
		            	coords = '50% '+ yPos + 'px';
		            // Move the background
		            item.css({ backgroundPosition: coords });
		        });
		    });
        }

        //Developer Options
	    if(options.developerMode){
	    	console.log('Developer Mode');
	    }
	    //Preserve Chaining
	    return this;
    }   
     
}(jQuery));