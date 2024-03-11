(function ($) {
    'use strict';

    $(document).ready(function () {
        // Add active class to the current button (highlight it)
        // $('.card_check_box').on('click', function () {
        //     $('.card_check_box').each(function () {
        //         var platform_id = $(this).data('platform_id');
        //         if ($(this).is(':checked')) {
        //             $('#platform-' + platform_id).addClass('bg-active').removeClass('bg-disabled');
        //         } else {
        //             $('#platform-' + platform_id).removeClass('bg-active').addClass('bg-disabled');
        //         }
        //     });
        // });

        // Reset platforms
        $('#btn-yufinder-reset-plaforms').on('click', function () {
            $('.card_check_box').each(function () {
                $(this).prop('checked', false);
                var platform_id = $(this).data('platform_id');
                $('#platform-' + platform_id).removeClass('bg-disabled').addClass('bg-active');
            });
        });

        // Select all platforms
        $('#btn-yufinder-select-all').on('click', function () {
            $('.card_check_box').each(function () {
                $(this).prop('checked', true);
                var platform_id = $(this).data('platform_id');
                $('#platform-' + platform_id).addClass('bg-active').removeClass('bg-disabled');
            });
        });

        // Loop through all filters and add the filter_class to the filter_classes array
        // Then go through all platforms and check if the platform has all the filter_classes
        $('.yufinder-filter').on('click', function () {
            var filter_class = $(this).data('filter_class');
            var filter_id = $(this).data('filter_id');
            var filter = $(this);
            var checked = filter.is(':checked');
            // If filter is checked addfilter_class the the filter_classes array
            var filter_classes = [];
            if (checked) {
                filter_classes.push(filter_class);
            }

            // Now go through all platforms
            $('.yufinder_platform').each(function () {
                var platform_classes = $(this).attr('data-platform_classes').split(' ');
                var has_all_filters = filter_classes.every(function (val) {
                    return platform_classes.indexOf(val) >= 0;
                });

                if (has_all_filters) {
                    $(this).addClass('bg-active').removeClass('bg-disable');
                } else {
                    $(this).removeClass('bg-active').addClass('bg-disable');
                }
            });
        });

        // reset filters anf platforms when teh yufinder-reset-filters button is clicked
        $('#btn-yufinder-reset-filters').on('click', function () {
            $('.yufinder-filter').each(function () {
                $(this).prop('checked', false);
            });

            $('.yufinder_platform').each(function () {
                $(this).addClass('bg-active').removeClass('bg-disable');
            });
        });


    });
    $('.btn-checkbox, .btn-checkbox input, .btn-checkbox span').on('click', function () {
        console.log("here button check 2");
        /* $('.card_check_box').each(function () {
            $(this).prop('checked', true);
            var platform_id = $(this).data('platform_id');
            $('#platform-' + platform_id).addClass('bg-active').removeClass('bg-disabled');
        }); */
        // var id = $(this).attr('id');
        var id = $(this).attr('id').replace('-btn', '');
        console.log($(this));
        console.log(id);
        var cells = document.getElementsByClassName(id);
        // var cells = document.getElementsByClassName('platform-1');
        // Convert HTMLCollection to an array
        var cellsArray = Array.from(cells);

        console.log(cellsArray);

        cellsArray.forEach(function (cell) {
            if (cell.classList.contains('hidden')) {
                cell.classList.remove('hidden');
            } else {
                cell.classList.add('hidden');
            }
        });

        console.log("here done");

    });

    function platforms_table_layout_align() {

        // console.log("function run");

        var table = document.getElementById('comparisonchart');
        var rows = table.getElementsByTagName('tr');

        var th_cells = rows[0].getElementsByTagName('th');

        for (var j = 0; j < th_cells.length; j++) {

            var maxRowHeight = 0;

            console.log(th_cells[j]);

            var th_cell_index = th_cells[j].cellIndex;

            console.log(th_cell_index);

            if (th_cells[j].style.height) {
                // If it exists, remove the 'height' style property
                th_cells[j].style.removeProperty('height');
            }

            for (var i = 1; i < rows.length; i++) {
                var td_cells = rows[i].getElementsByTagName('td');
                // console.log(td_cells)
                for (var k = 0; k < td_cells.length; k++) {
                    if (k == th_cell_index - 1) {
                        if (td_cells[k].style.height) {
                            // If it exists, remove the 'height' style property
                            td_cells[k].style.removeProperty('height');
                        }
                        console.log(td_cells[k]);
                        maxRowHeight = Math.max(maxRowHeight, td_cells[k].offsetHeight);
                        console.log(maxRowHeight);
                    }
                }
            }
            for (var i = 1; i < rows.length; i++) {
                var td_cells = rows[i].getElementsByTagName('td');
                for (var k = 0; k < td_cells.length; k++) {
                    if (k == th_cell_index - 1) {
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

// Th JS below has nothing to do with the above JS

    function toggleColumn(id) {
        console.log("here in toggle");
        var cells = document.getElementsByClassName(id);
        // Convert HTMLCollection to an array
        var cellsArray = Array.from(cells);

        cellsArray.forEach(function (cell) {
            if (cell.classList.contains('hidden')) {
                cell.classList.remove('hidden');
            } else {
                cell.classList.add('hidden');
            }
        });
    }

    function selectAll() {
        var checkboxes = document.querySelectorAll('.btn-checkbox input[type="checkbox"]');
        checkboxes.forEach(function (checkbox) {
            if (!checkbox.checked) {
                checkbox.checked = true;
                checkbox.dispatchEvent(new Event('click')); // Dispatch a click event on the checkbox
            }
        });
    }

    function clearAll() {
        var checkboxes = document.querySelectorAll('.btn-checkbox input[type="checkbox"]');
        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                checkbox.checked = false;
                checkbox.dispatchEvent(new Event('click')); // Dispatch a click event on the checkbox
            }
        });
    }

    window.toggleColumn = toggleColumn;
    window.selectAll = selectAll;
    window.clearAll = clearAll;
});



