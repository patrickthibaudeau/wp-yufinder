(function ($) {
    'use strict';

    $(document).ready(function () {

        //defining filter arrays
        var filter_classes = [];
        var filter_classes_radio = [];

        // reset all
        reset_all();

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
                $('.td-platform-' + this_platform_id).show();
                $('.td-platform-' + this_platform_id).removeClass('ignore');
            } else {
                // Hide the table row for this platform
                $('.td-platform-' + this_platform_id).hide();
                $('.td-platform-' + this_platform_id).addClass('ignore');
                //Remove success from the comparison checkbox
                $('#btn-yufinder-comparison-checkbox-' + this_platform_id).removeClass('btn-success').removeClass('checked').addClass('btn-secondary');
                // Hide btn-yufinder-comparision-checkbox-{{platformid}}
                $('#btn-yufinder-comparison-checkbox-' + this_platform_id).hide();
                // If no platform is checked, hide the comparison table
                var all_checked = false;
                $('.comparison-checkbox').each(function () {
                    if ($(this).hasClass('checked')) {
                        all_checked = true;
                    }
                });

                if (!all_checked) {
                    $('#yufinder-comparison-table-container').hide();
                }

                // if this is the only card_check_box that is checked, hide the yufinder-table-container
                var all_unchecked = true;
                $('.card_check_box').each(function () {
                    if ($(this).is(':checked')) {
                        all_unchecked = false;
                    }
                });

                if (all_unchecked) {
                    $('#yufinder-table-container').hide();
                }
            }
        });

        // Reset platforms
        $('.btn-yufinder-reset').on('click', function () {
            reset_all();
        });

        // Select all platforms
        $('#btn-yufinder-select-all').on('click', function () {
            $('.card_check_box').each(function () {
                var platform_id = $(this).data('platform_id');
                if ($('#platform-' + platform_id).hasClass('bg-active')) {
                    $(this).prop('checked', true);
                    $('#platform-' + platform_id).addClass('bg-active').removeClass('bg-disabled');
                    $('.td-platform-' + platform_id).show();
                    $('.td-platform-' + platform_id).removeClass('ignore');
                    $(this).trigger('change');

                    $('.comparison-checkbox').each(function () {
                        // remove success from the comparison checkbox
                        if ($('#platform-' + $(this).data('platform_id')).hasClass('bg-active')) {
                            $(this).removeClass('btn-secondary').addClass('checked').addClass('btn-success');
                            $(this).show();
                        }
                    });
                }

                $('#yufinder-comparison-table-container').show();
                $('#yufinder-table-container').show();
            });
        });

        // Loop through all filters and add the filter_class to the filter_classes array
        // Then go through all platforms and check if the platform has all the filter_classes
        $('.yufinder-filter').on('click', function () {
            var filter_class = $(this).data('filter_class');
            var filter_id = $(this).data('filter_id');
            var filter_type = $(this).prop('type');
            var filter = $(this);
            var checked = filter.is(':checked');
            //get parent filter id
            var radiopointer = $($(this).closest('fieldset')).prop('id');

            // If filter is checked addfilter_class the the filter_classes array
            if (filter_type == 'radio') {
                //make a key value pair with the filter
                filter_classes_radio[radiopointer] = filter_class;
            } else {
                if (checked) {
                    filter_classes.push(filter_class);
                } else {//remove unchecked filter
                    let index = filter_classes.indexOf(filter_class);
                    if (index > -1) {
                        filter_classes.splice(index, 1);
                    }
                }
            }

            // Now go through all platforms
            $('.yufinder_platform').each(function () {
                var platform_classes = $(this).attr('data-platform_classes').split(' ');
                var has_all_filters = filter_classes.every(function (val) {
                    return platform_classes.indexOf(val) >= 0;
                });

                let radio_filters = true;
                for (var key in filter_classes_radio) {
                    if (platform_classes.indexOf(filter_classes_radio[key]) === -1) {
                        radio_filters = false;
                        break;
                    }
                }

                if (has_all_filters && radio_filters) {
                    $(this).addClass('bg-active').removeClass('bg-disabled');
                } else {
                    $(this).removeClass('bg-active').addClass('bg-disabled');
                    let checkbox = $(this).find('.card_check_box');
                    $(checkbox).prop('checked', false);
                    // Remove from comparison table and filter
                    $('.td-platform-' + $(checkbox).data('platform_id')).hide();
                    $('.td-platform-' + $(checkbox).data('platform_id')).addClass('ignore');
                    $('#btn-yufinder-comparison-checkbox-' + $(checkbox).data('platform_id')).hide();
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
                $('.td-platform-' + platform_id).hide().addClass('ignore');
                $(this).removeClass('btn-success').removeClass('checked').addClass('btn-secondary');
            } else {
                $('.td-platform-' + platform_id).show().removeClass('ignore');
                $('#yufinder-comparison-table-container').show();
                $(this).removeClass('btn-secondary').addClass('btn-success').addClass('checked');
            }

            // Loop through all .comparison-checkbox. If none have class checked, hide the comparison table
            var all_checked = false;
            $('.comparison-checkbox').each(function () {
                if ($(this).hasClass('checked')) {
                    all_checked = true;

                }
            });

            if (!all_checked) {
                $('#yufinder-comparison-table-container').hide();
            }
        });

        // Reset all
        function reset_all() {
            $('.card_check_box').each(function () {
                $(this).prop('checked', false);
                var platform_id = $(this).data('platform_id');
                $('#platform-' + platform_id).removeClass('bg-disabled').addClass('bg-active');
                $('.td-platform-' + platform_id).hide().addClass('ignore');
                $(this).trigger('change');

                $('.comparison-checkbox').each(function () {
                    // remove success from the comparison checkbox
                    $(this).removeClass('btn-success').removeClass('checked').addClass('btn-secondary');
                    $(this).hide();
                });

                $('#yufinder-comparison-table-container').hide();

                // if this is the only card_check_box taht is cheked, hide the yufinder-table-container
                $('.card_check_box').each(function () {
                    $(this).prop('checked', false);
                });

                $('#yufinder-table-container').hide();
            });
            // Reset filters
            $('.yufinder-filter').each(function () {
                $(this).prop('checked', false);
            });
        }

        // Export to CSV
        $('#yufinder-export-to-csv').on('click', function () {
            $("#yufinder-comparison-table").tableHTMLExport({

                // csv, txt, json, pdf
                type:'csv',

                // file name
                filename:'comparison.csv',

                ignoreColumns: '.ignore'
            });
        });

    });

})(jQuery);
