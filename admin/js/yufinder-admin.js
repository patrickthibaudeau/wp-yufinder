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
		});
		if(window.location.href.indexOf("yufinder-edit-platform") > -1){
			// Add class to the post type

			$('form').on('submit', function(e){
				let valid=true
				//validate fields
				$('.question-textarea').each(function(){
					if($(this).val() == ""){
						valid = false;
						alert("Please fill in all the fields");
						return false;
					}
				});
				//validate select fields


				$('optgroup').each(function(){
					//cover each option in option group
					let validgroup=false;
					//check if any of the options are selected
					$(this).children("option").each(function(){
						if($(this).is(':selected')) {
							validgroup = true;
							return false;
						}
					});
					if(!validgroup) {
						alert("Please select an option for each question")
						valid = false;
					}
				});

				if(!valid) {

					e.preventDefault();
				}
			});
		}
	});
})( jQuery );
