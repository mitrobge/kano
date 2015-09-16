$(document).ready(function() {

    function click_address_book() {
        $('#checkout #new_address').hide();
        $('#checkout #to_new_address h2').removeClass('heading');
        $('#checkout #to_new_address h2').addClass('heading_inactive');
        $('#checkout #address_book').toggle();

        if( $('#checkout #address_book').is(':visible') ) {
            $('#checkout #default_address').hide();
            $('#checkout #to_address_book h2').removeClass('heading_inactive');
            $('#checkout #to_address_book h2').addClass('heading');
            $('#checkout input[name="new_shipping_method"]').val('address_book');
        }
        else {
            $('#checkout #to_address_book h2').removeClass('heading');
            $('#checkout #to_address_book h2').addClass('heading_inactive');
            $('#checkout #default_address').show();
            $('#checkout input[name="new_shipping_method"]').val('');
        }
    }

    function click_new_address() {
        $('#checkout #address_book').hide();
        $('#checkout #to_address_book h2').removeClass('heading');
        $('#checkout #to_address_book h2').addClass('heading_inactive');
        $('#checkout #new_address').toggle();

        if( $('#checkout #new_address').is(':visible') ) {
            $('#checkout #default_address').hide();
            $('#checkout #to_new_address h2').removeClass('heading_inactive');
            $('#checkout #to_new_address h2').addClass('heading');
            $('#checkout input[name="new_shipping_method"]').val('new_address');
        }
        else {
            $('#checkout #to_new_address h2').removeClass('heading');
            $('#checkout #to_new_address h2').addClass('heading_inactive');
            $('#checkout #default_address').show();
            $('#checkout input[name="new_shipping_method"]').val('');
        }
    }

    function click_default_address() {
        $('#checkout #address_book').hide();
        $('#checkout #to_address_book h2').removeClass('heading');
        $('#checkout #to_address_book h2').addClass('heading_inactive');
        $('#checkout #new_address').hide();
        $('#checkout #to_new_address h2').removeClass('heading');
        $('#checkout #to_new_address h2').addClass('heading_inactive');
        $('#checkout #to_default_address h2').removeClass('heading_inactive');
        $('#checkout #to_default_address h2').addClass('heading');
        $('#checkout #default_address').show();
        $('#checkout input[name="new_shipping_method"]').val('');
    }

    $('#checkout input[name="address_book_id"]:radio').live('click', function(e) { 
        $("#address_book>li.selectedAddress").removeClass("selectedAddress");
        $(this).parent().addClass('selectedAddress');
    });

    $('#checkout #to_address_book').live('click', function(e) {
        click_address_book();
        var val = $('input[name="address_book_id"]:radio:checked').val();
        if (val == undefined)
            ;
        else {
            $.getJSON("json/get_shipping_cost.php",{address_book_id: val}, function(j){
                $("#checkout #shipping_cost").html(j[0].shippingCost);
                $("#checkout #shipping_extra_cost").html(j[0].shippingCostExtra);
                $("#checkout #shipping_total_cost").html(j[0].shippingTotalCost);
            })
        }
        return false;
    });
    $('#checkout #to_new_address').live('click', function(e) {
        click_new_address();
        var val = $('select[name="state_id"]').val();
        if (val.length > 0) {
            $.getJSON("json/get_shipping_cost.php",{state_id: val}, function(j){
                $("#checkout #shipping_cost").html(j[0].shippingCost);
                $("#checkout #shipping_extra_cost").html(j[0].shippingCostExtra);
                $("#checkout #shipping_total_cost").html(j[0].shippingTotalCost);
            })
        }
        return false;
    });
    $('#checkout #to_default_address').live('click', function(e) {
        click_default_address();
        $.getJSON("json/get_shipping_cost.php", function(j){
            $("#checkout #shipping_cost").html(j[0].shippingCost);
            $("#checkout #shipping_extra_cost").html(j[0].shippingCostExtra);
            $("#checkout #shipping_total_cost").html(j[0].shippingTotalCost);
        })
        return false;
    });
    $('#checkout input[name="invoice_req"]').live('click', function(e) {
        $('#checkout #invoice').toggle();
        return true;
    });

    $('#checkout select[name="state_id"]').change(function(){
        $.getJSON("json/get_shipping_cost.php",{state_id: $(this).val()}, function(j){
            $("#checkout #shipping_cost").html(j[0].shippingCost);
            $("#checkout #shipping_extra_cost").html(j[0].shippingCostExtra);
            $("#checkout #shipping_total_cost").html(j[0].shippingTotalCost);
        })
    })
    
    $('#checkout input[name="address_book_id"]:radio').change(function(){
        $.getJSON("json/get_shipping_cost.php",{address_book_id: $(this).val()}, function(j){
            $("#checkout #shipping_cost").html(j[0].shippingCost);
            $("#checkout #shipping_extra_cost").html(j[0].shippingCostExtra);
            $("#checkout #shipping_total_cost").html(j[0].shippingTotalCost);
        })
    })
});
