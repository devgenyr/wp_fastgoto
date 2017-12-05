jQuery(document).ready(function($) {

	// var locations = [
	// 				"Home",
	// 				"Plugins",
	// 				"Options",
	// 				"New post",
	// 		];

	function listLocations() {
		var search = $('#wpm_gt_search_input').val();
		var options = {
				pre: "<b>",
				post: "</b>",
				extract: function(el) { return el.title; }
		};

		var filtered = fuzzy.filter(search, wpm_gt_locations, options);

		// process the results to extract the strings
		var newLocations = filtered.map( function(el) {
			var render;
			render = '<li><a href="' + wpm_gt_admin_url + el.original.link + '">';
			if ( el.original.isSubmenu ) {
				render += wpm_gt_locations[el.original.parent].title + ' > ';
			}
			render += el.string + '</a><span>/' + el.original.link + '</span></li>';
			return render;
		});

		$('#wpm_gt_search_results').html( newLocations.join('') );
	}

	// List the initial locations
	listLocations();
	// Filter the locations on each change of the textbox
	$('#wpm_gt_search_input').keyup(listLocations);

});