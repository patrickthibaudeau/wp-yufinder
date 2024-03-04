(function ($) {
    'use strict';

    /**
     * All of the code for your public-facing JavaScript source
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

    function toggleColumn(id) {
        var cells = document.getElementsByClassName(id);
        // Convert HTMLCollection to an array
        var cellsArray = Array.from(cells);

        cellsArray.forEach(function(cell) {
            if (cell.classList.contains('hidden')) {
                cell.classList.remove('hidden');
            } else {
                cell.classList.add('hidden');
            }
        });
    }

    function selectAll() {
        var checkboxes = document.querySelectorAll('.btn-checkbox input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            if (!checkbox.checked) {
                checkbox.checked = true;
                checkbox.dispatchEvent(new Event('click')); // Dispatch a click event on the checkbox
            }
        });
    }

    function clearAll() {
        var checkboxes = document.querySelectorAll('.btn-checkbox input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                checkbox.checked = false;
                checkbox.dispatchEvent(new Event('click')); // Dispatch a click event on the checkbox
            }
        });
    }

    window.toggleColumn = toggleColumn;
    window.selectAll = selectAll;
    window.clearAll = clearAll;

})(jQuery);
