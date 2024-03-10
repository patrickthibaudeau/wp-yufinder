(function ($) {
    'use strict';

    $(document).ready(function () {
        // Add active class to the current button (highlight it)
        $('.card_check_box').on('click', function () {

            // Check if checked or not
            var checked = $(this).is(':checked');
            var this_platform_id = $(this).data('platform_id');
            if (checked) {
                // Make yufinder-table-conatiner visible
                $('#yufinder-table-container').show();
                // make btn-yufinder-comparison-checkbox-{{plaformid}} checked
                $('#btn-yufinder-comparison-checkbox-' + this_platform_id).addClass('checked').addClass('btn-success').removeClass('btn-secondary');
                // Show btn-yufinder-comparison-checkbox-{{plaformid}}
                $('#btn-yufinder-comparison-checkbox-' + this_platform_id).show();
                // Show the table
                $('#yufinder-comparison-table-container').show();
                // Show table row for this platform
                $('.tr-platform-' + this_platform_id).show();
            } else {
                // Hide the table row for this platform
                $('.tr-platform-' + this_platform_id).hide();
                //Remove success from the comparison checkbox
                $('#btn-yufinder-comparison-checkbox-' + this_platform_id).removeClass('btn-success').removeClass('checked').addClass('btn-secondary');
                // Hide btn-yufinder-comparision-checkbox-{{platformid}}
                $('#btn-yufinder-comparison-checkbox-' + this_platform_id).hide();
                // If no platform is checked, hide the comparison table
                var all_checked = false;
                $('.comparison-checkbox').each(function () {
                    if ($(this).hasClass('checked')) {
                        all_checked = true;
                        return
                    }
                });

                if (!all_checked) {
                    $('#yufinder-comparison-table-container').hide();
                }

                // if this is the only card_check_box taht is cheked, hide the yufinder-table-container
                var all_unchecked = true;
                $('.card_check_box').each(function () {
                    if ($(this).is(':checked')) {
                        all_unchecked = false;
                        return
                    }
                });

                if (all_unchecked) {
                    $('#yufinder-table-container').hide();
                }
            }


        });

        // Reset platforms
        $('#btn-yufinder-reset-plaforms').on('click', function () {
            $('.card_check_box').each(function () {
                $(this).prop('checked', false);
                var platform_id = $(this).data('platform_id');
                $('#platform-' + platform_id).removeClass('bg-disabled').addClass('bg-active');
                $(this).trigger('change');
                // If no platform is checked, hide the comparison table
                var all_checked = false;
                $('.comparison-checkbox').each(function () {
                    if ($(this).hasClass('checked')) {
                        all_checked = true;
                        return
                    }
                });

                if (!all_checked) {
                    $('#yufinder-comparison-table-container').hide();
                }

                // if this is the only card_check_box taht is cheked, hide the yufinder-table-container
                var all_unchecked = true;
                $('.card_check_box').each(function () {
                    if ($(this).is(':checked')) {
                        all_unchecked = false;
                        return
                    }
                });

                if (all_unchecked) {
                    $('#yufinder-table-container').hide();
                }
            });
        });

        // Select all platforms
        $('#btn-yufinder-select-all').on('click', function () {
            $('.card_check_box').each(function () {
                $(this).prop('checked', true);
                var platform_id = $(this).data('platform_id');
                $('#platform-' + platform_id).addClass('bg-active').removeClass('bg-disabled');
                $(this).trigger('change');
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

        // When checkbox with class comparison-checkbox is clicked, check if it is checked or not
        // Get the dat-platform_id attibute and use it to show or hide the tr-platform-<platform_id> table row
        $('.comparison-checkbox').on('click', function () {
            var platform_id = $(this).data('platform_id');
            var checked = $(this).hasClass('checked');
            if (checked) {
                $('.tr-platform-' + platform_id).hide();
                $(this).removeClass('btn-success').removeClass('checked').addClass('btn-secondary');
            } else {
                $('.tr-platform-' + platform_id).show();
                $('#yufinder-comparison-table-container').show();
                $(this).removeClass('btn-secondary').addClass('btn-success').addClass('checked');
            }

            // Loop through all .comparison-checkbox. If none have class checked, hide the comparison table
            var all_checked = false;
            $('.comparison-checkbox').each(function () {
                if ($(this).hasClass('checked')) {
                    all_checked = true;
                    return
                }
            });

            if (!all_checked) {
                $('#yufinder-comparison-table-container').hide();
            }
        });

    });

})(jQuery);
