$(document).ready(function() {

    // Fetch our original document title
    var document_title = document.title;
    
    // The array key is the hash (minus the sharp-#) and has two items in the array, 
    // the url of the page and the title.
    var ajaxPath = new Array();

    //var anchor = $.url.attr('anchor');
    //if (anchor != null) {
    //    if (anchor.indexOf('link:') > -1) {
    //        var link = anchor.substring('link:'.length, anchor.indexOf('callback'));
    //        var callback = anchor.substring(anchor.indexOf('callback:') + 'callback:'.length, anchor.length);
    //        if (link.indexOf('?') < 0)
    //            link = link + 'AjaxReq';
    //        else
    //            link = link + '&AjaxReq';
    //        $.ajax({ url: link, 
    //                 cache: false,
    //                 success: function(result){
    //                    fun = eval(callback);
    //                    fun(result);
    //                 }
    //        });
    //    }
    //}
 
    function getHash(obj) {
        var link;

        if ($(obj).is('a')) {
            link = $(obj).attr('href');
        }
        else if ($(obj).is('input:submit')) {
            link = $(obj).parents('form').attr('action').toString();
            if (!link.length) {
				if ( typeof window.location.hash !== 'undefined' )
                    link = window.location;
                else
                    link = location;
            }
        }
        
        var path = $.url.setUrl(link).attr("relative");

        if ($.url.attr("file") != null) {
            if (path.indexOf("&") > -1)
                return path.substring(
                        "/marsellos/index.php?".length, path.indexOf("&"));
            else
                return path.substring(
                        "/marsellos/index.php?".length, path.length);
        } else
            return path.substring(
                    "/marsellos/".length, path.length - 1);
    }

    function setLocation() {
        var hash;
        var newPath = $.url.attr("relative");
        
        if ($.url.attr("file") != null) {
            if (newPath.indexOf("&") > -1)
                hash = newPath.substring(
                        "/marsellos/index.php?".length, newPath.indexOf("&"));
            else
                hash = newPath.substring(
                        "/marsellos/index.php?".length, newPath.length);
        } else
            hash = newPath.substring(
                    "/marsellos/".length, newPath.length - 1);
        
        if ( typeof window.location.hash !== 'undefined' )
            window.location.hash = hash;
        else
            location.hash = hash;
    }

    function cartDetailsResult(result) {
        $("#central_banner").empty();
        $("#vertical_banner").empty();
        $("#content_cell").html(result);

        $('#cart_summary #total_items').html($('#cart_details #details_total_items').html());
        $('#cart_summary #total_amount').html($('#cart_details #details_total_amount').html());
    }
    
    function productTabResult(result) {
        $("#product .panes").html(result);
    }

    function productsListResult(result) {
        $("#central_banner").empty();
        $("#vertical_banner").empty();
        $("#content_cell").html(result);
    }

    function searchResult(result) {
        productsListResult(result);
        var search_url_link = $("#products_list #search_results_url");
        if (search_url_link.length > 0) {
            $('#search_box #search_form input[name="search_string"]').val('');
            var hash = getHash(search_url_link);
            //alert('hash: ' + hash);
            document.title = document_title + ' | ' + hash;
            
            if (typeof ajaxPath[hash] === 'undefined') {
                ajaxPath[hash] = new Array(search_url_link, productsListResult);
            } else {
                ajaxPath[hash][0] = search_url_link;
            }

            $.History.skipNextHashChange = true;
            
            // Unbind the hashchange function
            //$.History.$window.unbind('hashchange');
            //alert('unbinded ...');
                
            setLocation();
            
            //setTimeout(function() {
            //    // Apply the hashchange function
            //    $.History.$window.bind('hashchange', $.History.hashchange);
            //    //alert('binded ...');
            //}, 1);
        }
        //alert('done');
    }
    
    function categoriesListResult(result) {
        if (result.indexOf("<div id=\"subcategories_list\"") > -1)
            $("#center_content").html(result);
        else
            productsListResult(result);
    }

    function productResult(result) {
        $("#central_banner").empty();
        $("#vertical_banner").empty();
        $("#content_cell").html(result);
    }
    
    function ordersListResult(result) {
        $("#content_cell").html(result);
    }

    function customerActionResult(result) {
        if (!$('#customer_account').length)
            $('#center_content').empty().append(
                    '<div id=\"customer_account\"></div>');
        $('#customer_account').html(result);
    }
 
    function advancedSearchResult(result) {
        $('#advanced_search').append(result);
        $('#advanced_search').find('#to_search_results').find('a').trigger('click');
    }
    
    function filtersResult(result) {
        tmp = result.substring(result.indexOf("<div id=\"to_filter_results\""), result.length);
        toResults = tmp.substring(0, tmp.indexOf("</div>"));
        $('#products_list_filters').append(toResults);
        $('#products_list_filters').find('#to_filter_results').find('a').trigger('click');
    }
    
    function productsCompareResult(result) {
        $("#content_cell").html(result);
    }
    
    function doAjax(obj, onSuccess) {
        var isForm = false;
        var isPost = false;
        var link;
        var getUrl;

        if ($(obj).is('a')) {
            link = $(obj).attr('href');
        }
        else if ($(obj).is('input:submit') || $(obj).is('input:image') || $(obj).is('select')) {
            isForm = true;
            if ($(obj).parents('form').attr('method') == 'post')
                isPost = true;
            link = $(obj).parents('form').attr('action').toString();
            if (!link.length)
                link = window.location;
        }
        else {
            alert('Undefined Object for Ajax Request');
        }
        
        // http -> https or https -> http (Ajax is not supported) 
        if ($.url.setUrl(window.location).attr("protocol") != 
                $.url.setUrl(link.toString()).attr("protocol")) {
            //alert($.url.setUrl(window.location).attr("protocol"));
            //alert($.url.setUrl(link.toString()).attr("protocol"));
            //var redirect = link.toString().substring(0, link.indexOf("/marsellos/") + "/marsellos/".length);
            //window.location = redirect + "#" + "link:" + link + "callback:" + 
            //    onSuccess.toString().substring("function ".length, onSuccess.toString().indexOf("("));
            //$.load(link);
            //return false;
            window.location = link;
            return false;
        }
        
        if (link.toString().indexOf('?') < 0)
            link = link + 'AjaxReq';
        else
            link = link + '&AjaxReq';
        
        if (!isPost) {
            $.ajax({ url: link, 
                     cache: false,
                     success: function(result){
                        onSuccess(result);
                     }
            });
        } else {
            var button = $(obj).attr('name') + "=" + $(obj).val();
            var post = $(obj).parents('form').serialize() + "&" + button;
            $.ajax({ url: link, 
                     type: 'POST',
                     data: post,
                     cache: false,
                     success: function(result){
                        onSuccess(result);
                     }
            });
        }

        return false;
    }
    
    //function pageLoad(hash) {
    //    if(hash) {
    //        doAjax(ajaxPath[hash][0], ajaxPath[hash][1]);
    //    }
    //    else {
    //        //default path
    //        //Load your default page, or do nothing at all.
    //        //$.load(window.location);
    //    }
    //}    
    //
    // Initialize history plugin.
    // The callback is called at once by present location.hash. 
    //$.history.init(pageLoad);

    // Bind a handler for ALL hash/state changes
    $.History.bind(function(hash){
        if(hash == "") {
            //default path
            //Load your default page, or do nothing at all.
            if ( typeof window.location.hash !== 'undefined' )
                window.location.reload(true);
            else
                location.reload(true);
        } else {
            //alert('will try doing ajax for hash: ' + hash);
            if (ajaxPath[hash] != undefined && ajaxPath[hash] != 0) {
                //alert('doing ajax for hash: ' + hash);
                doAjax(ajaxPath[hash][0], ajaxPath[hash][1]);
                document.title = document_title + ' | ' + hash;
            }
        }
    });
  
/*    
    $('#customer_account').find('#registration_form').find(
            'input[name="submit_customer_register"]').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, 
                function(result) {
                    if (!$('#customer_account').length)
                        $('#center_content').empty().append(
                            '<div id=\"customer_account\"></div>');
                    $('#customer_account').html(result);
                }
        );
    });
*/    
    $('#customer_account').find('#account_form').find(
            'input[name="submit_customer_update"]').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, 
                function(result) {
                    $('#customer_account').html(result);
                }
        );
    });
    
    $('#customer_account').find('#account_form').find(
            'input[name="submit_customer_change_password"]').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, 
                function(result) {
                    $('#customer_account').html(result);
                }
        );
    });
    
    $('#customer_account').find('#to_wish_list').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, cartDetailsResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#masthead').find('#to_wish_list').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, cartDetailsResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#customer_account').find('#to_change_password').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, customerActionResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#customer_account').find('#to_orders_history').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, ordersListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#customer_account').find('#to_recently_viewed_products').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productsListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#customer_account').find('#to_account_details').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, customerActionResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#cart_details').find('#cart_form').find(
            'input[name="update"]').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined)
            return doAjax(obj, function(result) {$('#cart_summary #to_cart_details').trigger('click')} );
        else
            return doAjax(obj, cartDetailsResult);
    });
   
    $('#product').find('#add_to_cart_form').find(
            'input[name="submit_add_to_cart"]').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        var empty_option = false;

        $('#product').find('select[name*=opt_]').each(function() {
            if ($(this).val() == "") {
                empty_option = true;
                return false;
            }
        })

        if (empty_option) {
            $('#product').find('#optionemptyerror').show();
            return false;
        }

        if (ajaxPath[hash] == undefined)
            return doAjax(obj, function(result) {$('#cart_summary #to_cart_details').trigger('click')} );
        else
            return doAjax(obj, cartDetailsResult);
    });
    
    $('#product .tabs a').live('click', function(e) {
        $('#cmpdeselect').trigger('click');
        $('#comparison').hide();
        var obj = $(this);
        //$('#product').find('#product_tabs_links').find('a').each(function(index) {
        //    if ($(this).attr('href') != obj.attr('href'))
        //        $(this).bind('click');
        //});
        return doAjax(obj, 
                function(result) {
                    //obj.unbind('click');
                    productTabResult(result);
                }
        );
    });
    
    $('#product').find('#spare_items').find('a').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productsListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#product').find('#groupset_items').find('a').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#product #related_products a').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productsListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#cart_details #to_cart_action').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined)
            return doAjax(obj, function(result) {$('#cart_summary #to_cart_details').trigger('click')} );
        else
            return doAjax(obj, cartDetailsResult);
    });
    
    $('#cart_details #to_product_details').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#cart_summary #to_cart_details').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, cartDetailsResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#products_list #page_navigation a').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productsListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#categories_list a').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, categoriesListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#subcategories_list a').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, categoriesListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#categories_expand_menu a').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, categoriesListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#products_latest a').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#products_list [id*=to_product_]').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('[id*=cmpnow]').live('click', function(e) {
        var obj = $('a#to_products_compare');
        var link = obj.attr('href');
        var checked = 0;
        
        $('input[name^="compare_product_"]').each(function(index, value){
            if ($(this).is(':checked')) {
                link += $(this).attr('value') + ',';
                checked++;
            }
        });

        if (checked < 2) {
            alert('Πρέπει να επιλέξετε τουλάχιστον δύο προϊόντα');
            return false;
        }
      
        if (link.toString().lastIndexOf(',') > -1)
            link = link.toString().substring(0, link.toString().length - 1);
        link += '/';
        
        obj.attr('href', link);

        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productsCompareResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#products_comparison a[id^=to_compare_]').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productsCompareResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#header').find('#menu').find('#to_shopping_cart').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, cartDetailsResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#header').find('#menu').find('#to_customer_account').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, customerActionResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#masthead #navigation #to_product_offers').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productsListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#masthead #navigation #to_product_arrivals').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productsListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });

    $('#customer_info').find('#to_customer_account').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, customerActionResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });

    $('#customer_login').find('#to_customer_register').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, customerActionResult);
    });
    
    $('#checkout').find('#checkout_form').find(
            'input[name="submit_place_order"]').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, 
            function(result) {
                if (result.indexOf("<div id=\"checkout_success\"") > -1) {
                    $('#cart_summary #total_items').html('0');
                    $('#cart_summary #total_amount').html('0&euro');
                }
                $('#checkout').html(result);
            }
        );
    });
 
    $('#advanced_search').find('#to_search_results').find('a').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productsListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
            
    $('#search_box #search_form input[name="submit_search"]').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, searchResult);
    });
    
    $('#to_advanced_search').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, function(result) { 
                $("#central_banner").empty(); 
                $("#vertical_banner").empty();
                $("#content_cell").html(result) 
            });
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#advanced_search #advanced_search_form input[name="submit_search_advanced"]').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, searchResult);
    });

    $('#products_list_filters').find('#filters_form').find(
            'input[name="submit_filter"]').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, filtersResult);
    });
    
    $('#products_list_filters').find('#to_filter_results').find('a').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productsListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#product_reviews #page_navigation a').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, 
                function(result) {
                    productTabResult(result);
                }
        );
    });
    
    $('form#add_review input[name="AddProductReview"]').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, 
                function(result) {
                    productTabResult(result);
                }
        );
    });
    
    $('#product_questions #page_navigation a').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, 
                function(result) {
                    productTabResult(result);
                }
        );
    });
    
    $('form#add_question input[name="AddProductQuestion"]').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, 
                function(result) {
                    productTabResult(result);
                }
        );
    });
    
    $('#products_comparison').find('#buy_now_form').find(
            'input[name^="submit_add_to_cart"]').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        var productId = $(this).attr('name');
        var link;
        
        productId = productId.substring(productId.lastIndexOf('_') + 1, productId.length);
        link = $('#products_comparison').find('#link_to_add_to_cart_' + productId).attr('href');
        
        $(this).parents('form').attr('action', link);

        if (ajaxPath[hash] == undefined)
            return doAjax(obj, function(result) {$('#cart_summary #to_cart_details').trigger('click')} );
        else
            return doAjax(obj, cartDetailsResult);
    });
    
    $('#products_comparison').find('[id*=to_product_]').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productsListResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#products_list').find('select#products_per_page').live('change', function(e) {
        var obj = $(this);
        return doAjax(obj, productsListResult);
    });

    $('#products_list #products_per_page_form input[name="submit_products_per_page"]').live('click', function(e) {
        var obj = $(this);
        return doAjax(obj, productsListResult);
    });
    
    $('#customer_orders').find('[id*=to_product_]').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#articles').find('[id*=to_article_]').live('click', function(e) {
        var obj = $(this);
        var hash = getHash(obj);
        if (ajaxPath[hash] == undefined) {
            ajaxPath[hash] = new Array(obj, productResult);
        } else {
            ajaxPath[hash][0] = obj;
        }
        $.History.go(hash);
        return false;
    });
    
    $('#product select[name*=opt_]').live('change', function(e) {
        $('#product #optionemptyerror').hide();
        var optsIds = '';
        var optsDesc = '';
        var branchesCount = 0;
        var emptyOption = false;
        var selects = $('#product').find('select[name*=opt_]');
        var selectName = $(this).attr('name');
        var tmp = selectName.substring(0, selectName.lastIndexOf('_'));
        var productId = tmp.substring(tmp.lastIndexOf('_') + 1, tmp.length);
        var availability = $('#product').find('#availability');
        var optionsDesc = $(availability).find('#optionsdescription');

        $.each(selects, function(idx, val) {
            if ($(this).val() == "") {
                emptyOption = true;
                return false;
            }

            optsDesc += $(this).attr('name').substring($(this).attr('name').lastIndexOf('_') + 1, $(this).attr('name').length) + ': ';
            optsDesc += $.trim($(this).find("option:selected").text());
            if (idx != selects.length - 1) 
                optsDesc += ', ';
            
            optsIds += $(this).val(); 
            if (idx != selects.length - 1) 
                optsIds += ','; 
        })

        if (emptyOption) {
            $(optionsDesc).html('');
            $(availability).find('#availabilitytable').hide();
            $(availability).find('#availabilitydefault').show();
            return false;
        }

        $(optionsDesc).html(' (' + optsDesc + ')');
        
        $(availability).find('[id ^=branch_][id $=_notavailable]').each(function(){
            $(this).hide();
        });

        $(availability).find('[id ^=branch_][id $=_available]').each(function(){
            $(this).show();
            branchesCount++;
        });
                    
        $('#product').find('#add_to_cart_form').find('input[name=\"submit_add_to_cart"]').removeAttr('disabled');
        $(availability).find('#onlineshop_notavailable').hide();
        $(availability).find('#onlineshop_available').show();

        $.getJSON("json/get_product_option_availability.php",{product_id: productId, product_options_ids: optsIds}, function(j){
            if (j != undefined) {
                for (var i = 0; i < j.length; i++) {
                    $(availability).find('#branch_' + j[i].branchId + '_available').hide();
                    $(availability).find('#branch_' + j[i].branchId + '_notavailable').
                        html(j[i].availabilityStatusDesc + ' ' + j[i].availabilitySchedule).show();
                }
                if (branchesCount == j.length) {
                    $('#product').find('#add_to_cart_form').find('input[name=\"submit_add_to_cart"]').attr('disabled', true);
                    $(availability).find('#onlineshop_available').hide();
                    $(availability).find('#onlineshop_notavailable').show();
                }
            }
        })
        $(availability).find('#availabilitydefault').hide();
        $(availability).find('#availabilitytable').show();
    });
});
