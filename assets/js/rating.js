$(function() {
    function ratingEnable() {
        $('#example-1to10_1').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_2').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_3').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_4').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_5').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_6').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_7').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_8').barrating('show', {
            theme: 'bars-1to10'
        });$('#example-1to10_9').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_10').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_11').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_12').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_13').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_14').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_15').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_16').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_17').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_18').barrating('show', {
            theme: 'bars-1to10'
        });$('#example-1to10_19').barrating('show', {
            theme: 'bars-1to10'
        });
        $('#example-1to10_20').barrating('show', {
            theme: 'bars-1to10'
        });

    }

    function ratingDisable() {
        $('select').barrating('destroy');
    }

    $('.rating-enable').click(function(event) {
        event.preventDefault();

        ratingEnable();

        $(this).addClass('deactivated');
        $('.rating-disable').removeClass('deactivated');
    });

    $('.rating-disable').click(function(event) {
        event.preventDefault();

        ratingDisable();

        $(this).addClass('deactivated');
        $('.rating-enable').removeClass('deactivated');
    });

    ratingEnable();
});
