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

    function platforms_table_layout_align () {

        var table = document.getElementById('comparisonchart');
        var rows = table.getElementsByTagName('tr');

        var th_cells = rows[0].getElementsByTagName('th');

        for (var j = 0; j < th_cells.length; j++) {

            var maxRowHeight = 0;

            console.log(th_cells[j]);

            var th_cell_index = th_cells[j].cellIndex;

            console.log(th_cell_index);

            for (var i = 1; i < rows.length; i++) {
                var td_cells = rows[i].getElementsByTagName('td');
                // console.log(td_cells)
                for (var k = 0; k < td_cells.length; k++) {
                    if (k == th_cell_index-1) {
                        console.log(td_cells[k]);
                        maxRowHeight = Math.max(maxRowHeight, td_cells[k].offsetHeight);
                        console.log(maxRowHeight);
                    }
                }
            }
            for (var i = 1; i < rows.length; i++) {
                var td_cells = rows[i].getElementsByTagName('td');
                for (var k = 0; k < td_cells.length; k++) {
                    if ( k == th_cell_index-1 ) {
                        // console.log(td_cells[k]);
                        td_cells[k].style.height = maxRowHeight + 'px';
                    }
                }
            }

            th_cells[j].style.height = maxRowHeight + 'px';
            // cells[j].style.height = 'auto';
            //maxRowHeight = Math.max(maxRowHeight, cells[j].offsetHeight);
        }
    }

    window.addEventListener('DOMContentLoaded', platforms_table_layout_align);
    window.addEventListener('resize', platforms_table_layout_align);

    /* window.addEventListener('DOMContentLoaded', function() {
        var table = document.getElementById('comparisonchart');
        var rows = table.getElementsByTagName('tr');

        var th_cells = rows[0].getElementsByTagName('th');

        for (var j = 0; j < th_cells.length; j++) {

            var maxRowHeight = 0;

            console.log(th_cells[j]);

            var th_cell_index = th_cells[j].cellIndex;

            console.log(th_cell_index);

            for (var i = 1; i < rows.length; i++) {
                var td_cells = rows[i].getElementsByTagName('td');
                // console.log(td_cells)
                for (var k = 0; k < td_cells.length; k++) {
                    if (k == th_cell_index-1) {
                        console.log(td_cells[k]);
                        maxRowHeight = Math.max(maxRowHeight, td_cells[k].offsetHeight);
                        console.log(maxRowHeight);
                    }
                }
            }
            for (var i = 1; i < rows.length; i++) {
                var td_cells = rows[i].getElementsByTagName('td');
                for (var k = 0; k < td_cells.length; k++) {
                    if ( k == th_cell_index-1 ) {
                        // console.log(td_cells[k]);
                        td_cells[k].style.height = maxRowHeight + 'px';
                    }
                }
            }

            th_cells[j].style.height = maxRowHeight + 'px';
            // cells[j].style.height = 'auto';
            //maxRowHeight = Math.max(maxRowHeight, cells[j].offsetHeight);
        }



    }); */

    window.toggleColumn = toggleColumn;
    window.selectAll = selectAll;
    window.clearAll = clearAll;

})(jQuery);
