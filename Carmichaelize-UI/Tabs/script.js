//Tabs Interface

function membershipTabs(tabButtons, tabContent) {

		// Cache Elements
		var tabbuttons = $(tabButtons);
		var tabContent = $(tabContent);


		// Apply Intial Classes to Buttons
		tabbuttons.children('li:first-child').addClass('first selected')
											 .siblings().eq(-2).addClass('last');


		// Apply Intial Classes to Content
		tabContent.children('div:first-child').addClass('open')
							 		 	 	  .siblings().hide();


		//Button Click Event
		tabbuttons.children('li').on('click', function(){

			var thisbutton = $(this);


			// Apply Classes to Content
			tabContent.children('div').eq(thisbutton.index()).show().addClass('open')
								 .siblings().removeClass('open').hide();

			// Apply 'selected' Class to clicked Button
			thisbutton.addClass('selected')
					  .siblings().removeClass('selected');

		});



}

membershipTabs('#tabs' ,'#tabCont');