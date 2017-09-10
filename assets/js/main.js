jQuery(document).ready(function($) {

	var locations = [
					"Home",
					"Plugins",
					"Options",
					"New post",
			];

	function listLocations() {
		var search = $('#wpm_fgt_search_input').val();
		var options = {
				pre: "<b>",
				post: "</b>"
		};
		var filtered = fuzzy.filter(search, locations, options);

		// process the results to extract the strings
		var newLocations = filtered.map(function(el) {
			return '<li>' + el.string + '</li>';
		});

		$('#wpm_fgt_search_results').html( newLocations.join('') );
	}

	// List the initial locations
	listLocations();
	// Filter the locations on each change of the textbox
	$('#wpm_fgt_search_input').keyup(listLocations);

});