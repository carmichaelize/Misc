function inputCounter2(textarea, counter, limit) {

	// Cache Elements

	var textarea = $(textarea);
	var counter = $(counter);
	
	var limit = limit;
	var alreadyentered = textarea.val().length;

	// Apply Intial Count Limit
	counter.html(limit - alreadyentered);

	textarea.on('keyup', function() {

		// Get Length of Input
		var inputlength = $(this).val().length;

		// Is Over The Limit
		if(inputlength > limit) {

			counter.html('<span class="over">' + (limit - inputlength) + '</span>');

		} else {

			counter.text(limit - inputlength);
		
		}


	});


}

inputCounter2('#commentBox', '#commentCounter', 100);