$(document).ready(function() {

    $('#cmpdeselect').live('click', function(e) {
        $('input[name^="compare_product_"]').each(function() {
            if ($(this).is(':checked')) {
                this.checked = false;
            }
        });
        if ($('#compareinfo').is(':visible'))
            $('#compareinfo').hide();
        if ($('#compareoneerror').is(':visible'))
            $('#compareoneerror').hide();
        if ($('#comparemaxerror').is(':visible'))
            $('#comparemaxerror').hide();
        $('#comparenum').html('0');
        return false;
    });

    $('input[name^="compare_product_"]').live('click', function(e) {
        var productsNumToCompare = parseInt($('#comparenum').html());
        if ($(this).is(':checked')) {
            var maxProductsToCompare = parseInt($('#cmpmaxproducts').html());
            if (productsNumToCompare == maxProductsToCompare) { 
                //$('#comparemaxerror').show();
                this.checked = false;
                alert('Δεν μπορείτε να συγκρίνετε πάνω από ' + maxProductsToCompare + ' προϊόντα');
                return false;
            }
            productsNumToCompare++;
            if (!($('#compareinfo').is(':visible')))
                $('#compareinfo').show();
        } else {
            productsNumToCompare--;
            if (productsNumToCompare == 0 && $('#compareinfo').is(':visible'))
                $('#compareinfo').hide();
        }
        $('#comparenum').html(productsNumToCompare);
    });
});
