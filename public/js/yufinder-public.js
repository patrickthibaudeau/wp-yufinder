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

    // Th JS below has nothing to do with the above JS

    function toggleColumn(id) {
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

})(jQuery);
