function modal(button, modalContainer) {

	// Cache Elements

	var button = $(button);
	var modal = $(modalContainer);

	modal.hide();


	function position(wrapper) {

		var wrapper = $(wrapper);
		var theWindow = $(window);

		var left = (theWindow.innerWidth() / 2) - (wrapper.outerWidth() / 2);
		var top = (theWindow.innerHeight() / 2) - (wrapper.outerHeight() / 2);

		console.log(theWindow.innerWidth());
		console.log(wrapper.outerWidth());

		//Apply Positions to wrapper
		wrapper.css({
		'position' : 'absolute',
		'top' : top,
		'left' : left
		});


	}

	button.on('click', function() {

		if($('.modalOverlay').length == 0) {

			modal.wrap('<div class="modalOverlay" style="width:'+ $(window).innerWidth() + 'px; height:' + $(window).innerHeight() + 'px;"></div>');

		} else {

			$('.modalOverlay').show();

		}

		modal.show().addClass('modalOpen');

		position(modalContainer);


		$('.modalOverlay').on('click', function() {

		$(this).hide();

		});

	});


}

modal('#modalBtn', '#modalCont');