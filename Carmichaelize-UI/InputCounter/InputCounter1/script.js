function inputCounter(textarea, counter, limit) {

	// Cache Elements

	var textarea = $(textarea);
	var counter = $(counter);
	

	var limit = limit;
	var alreadyentered = textarea.val().length;

	// Apply Intial Count Limit
	counter.html(alreadyentered + ' / '+ limit);

	textarea.on('keyup', function() {

		// Get Length of Input
		var inputlength = $(this).val().length;

		// Is Over The Limit
		if(inputlength > limit) {

			counter.html('<span class="over">' + inputlength + '</span>  / ' + limit);

		} else {

			counter.text(inputlength + ' / ' + limit);
		
		}


	});


}

inputCounter('#commentBox', '#commentCounter', 100);