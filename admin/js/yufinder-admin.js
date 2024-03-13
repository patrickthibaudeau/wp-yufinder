(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready(function(){
		// Control number of characters in short description
		$('#short_description').keyup(function(e) {
			var tval = $('#short_description').val(),
				tlength = tval.length,
				set = 125,
				remain = parseInt(set - tlength);
			$('#short_description_characters').text(remain);
			if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
				$('#short_description').val((tval).substring(0, tlength - 1))
			}
		})
	});
})( jQuery );
