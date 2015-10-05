{* admin_survey_details.tpl *}
{load_presentation_object filename="admin_survey_details" assign="obj"}

{literal}
<!-- jquery.datePicker.js --> 

 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
 
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="http://jquery-ui.googlecode.com/svn-history/r3874/branches/labs/datepicker2/ui/i18n/jquery.ui.datepicker-el.js"></script>
<script type="text/javascript" src="assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="assets/js/admin_actions.js"></script>
<script>
    $(function() {
         $( "#datepicker1" ).datepicker({ 
             minDate: 0,
             maxDate: "+365D",
             onSelect: function(selected) {
                 $("#datepicker2").datepicker("option","minDate", selected)
             },
             dateFormat: 'dd-mm-yy' 
             });
         });
    $(function() {
        $( "#datepicker2" ).datepicker({ 
             minDate: 0,
             maxDate: "+365D",
             onSelect: function(selected) {
                 $("#datepicker1").datepicker("option","maxDate", selected)
             },
             dateFormat: 'dd-mm-yy' 
             });
        });
    $(function() {
         $( "#datepicker3" ).datepicker({ 
             minDate: 0,
             maxDate: "+365D",
             onSelect: function(selected) {
                 $("#datepicker3").datepicker("option","minDate", selected)
             },
             dateFormat: 'dd-mm-yy' 
             });
         });
    $(function() {
        $( "#datepicker4" ).datepicker({ 
             minDate: 0,
             maxDate: "+365D",
             onSelect: function(selected) {
                 $("#datepicker4").datepicker("option","maxDate", selected)
             },
             dateFormat: 'dd-mm-yy' 
             });
        });
</script> 

{/literal}
{literal}
<!-- required plugins --> 
<script type="text/javascript" src="scripts/date.js"></script> 
<script type="text/javascript" src="scripts/jquery.dateFormat-1.0.js"></script> 

        <script language="javascript" type="text/javascript">
            /*
               @param1 - sourceid - This is the id of the multiple select box whose item has to be moved.
               @param2 - destinationid - This is the id of the multiple select box to where the iterms should be moved.
             */

        //this will move selected items from source list to destination list     
function move_list_items(sourceid, destinationid)
{
    $("#"+sourceid+"  option:selected").appendTo("#"+destinationid);
}

//this will move all selected items from source list to destination list
function move_list_items_all(sourceid, destinationid)
{
    $("#"+sourceid+" option").appendTo("#"+destinationid);
}

$(document).ready(function(){

        $.urlParam = function(name) {
        var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (!results) { return 0; }
        return results[1] || 0;
        }

        $("select#category_list").change(function(){
            $.getJSON("json/get_category_products.php",{category_id: $(this).val()}, function(j){
                var options = '';
                for (var i = 0; i < j.length; i++) {
                options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
                }
                $("#tmp_spares_list").html(options);
                //$('#spares_list option:first').attr('selected', 'selected');
                })
            })

        $("input[name=\"submit_add_spare_item\"]").click(function(){
            $("#spares_list option").attr("selected", "selected");
            })

        $("select#category_list_group").change(function(){
                $.getJSON("json/get_service_news.php",{product_id: $.urlParam('ProductId'), announcement_category_id: $(this).val()}, function(j){
                    var options = '';
                    for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
                    }
                    $("#tmp_groupset_list").html(options);
                    //$('#groupset_list option:first').attr('selected', 'selected');
                    })
                })

        $("input[name=\"submit_add_group_item\"]").click(function(){
                $("#groupset_list option").attr("selected", "selected");
                })

        $("select#category_list_related").change(function(){
                $.getJSON("json/get_service_news.php",{product_id: $.urlParam('ProductId'), announcement_category_id: $(this).val(), }, function(j){
                    var options = '';
                    for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
                    }
                    $("#tmp_related_list").html(options);
                    //$('#related_list option:first').attr('selected', 'selected');
                    })
                })

        $("input[name=\"submit_add_related_item\"]").click(function(){
                $("#related_list option").attr("selected", "selected");
                })

        $("#newsearch").click(function(){
                var category = $('#category_list_related').val();
                if (category.length == 0) {
                alert('Παρακαλώ επιλέξτε κατηγορία');
                return;
                }
                $.getJSON("json/get_random_candidate_related_products.php",{category_id: category, product_id: $.urlParam('ProductId')}, function(j){
                    var options = '';
                    for (var i = 0; i < j.length; i++) {
                    if (j[i].optionValue != $.urlParam('ProductId'))
                    options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
                    }
                    $("#tmp_related_list").html(options);
                    //$('#related_list option:first').attr('selected', 'selected');
                    })
                })

        /*
           $("select[name*=availability_status_id]").change(function(){
           var idx = $(this).attr('id').substring($(this).attr('id').lastIndexOf('_') + 1, $(this).attr('id').length);
           var selected = $(this).find(":selected");
           if ($(selected).attr('label') == "0") {
           $("#availability_schedule_" + idx).hide();
           } else if ($(selected).attr('label') == "1") {
           $("#availability_schedule_" + idx).show();
           } else {
           alert('Ops: Wrong label number');
           }
           })
         */

        /*$("#moveright").click(function() {
          $("#tmp_spares_list  option:selected").clone().appendTo("#spares_list");
          })

          $("#moverightall").click(function() {
          $("#tmp_spares_list  option").clone().appendTo("#spares_list");
          })

          $("#moveleft").click(function() {
          $("#spares_list  option:selected").remove();
          })

          $("#moveleftall").click(function() {
          $("#spares_list  option").remove();
          })*/
})
</script>
{/literal}




<form id="form" enctype="multipart/form-data" method="post"
    action="{$obj->mLinkToProductDetailsAdmin}">
    {if isset($smarty.get.CategoryId)}
    <h3>
        <a href="{$obj->mLinkToProductsAdmin}">Πίσω στις υπηρεσίες</a>
        <br>
        <br>
    </h3>
    {/if}
    {if $obj->mErrorMessage}<p style="color:red">{$obj->mErrorMessage}</p>{/if}

    


    <fieldset id="info">
        <br />
        <legend>Πληροφορίες Υπηρεσίας</legend>

        {section name=i loop=$obj->mProduct.name}

        <label style="width:120px;">{if $smarty.section.i.first}Όνομα :{/if}</label>
        <input type="text" name="product_name_{$obj->mProduct.language[i].language_id}"
        value="{$obj->mProduct.name[i]}" size="60" />
        {if count($obj->mProduct.name) > 1} 
        <img src="images/{$obj->mProduct.language[i].language_flag}" alt="{$obj->mProduct.language[i].language_name}" width="15" height="15" border="0" />
        {/if}
        </br>
        {/section}

        <br />

        <label style="width:140px"><b>Ενεργή έρευνα:</b></label>
        {if $obj->mProductActive}
        <input type="checkbox" id="is_active" value="1" checked name="is_active"/>
        {else}
        <input type="checkbox" id="is_active" value="1" name="is_active"/>
        {/if}
        
        <br />

        <label style="width:120px;">Περιγραφή: </label>
        {section name=i loop=$obj->mProduct.language}
        <br />
        <br />
        {if count($obj->mProduct.description) > 1} 
        <img src="images/{$obj->mProduct.language[i].language_flag}" alt="{$obj->mProduct.language[i].language_name}" width="15" height="15" border="0" />
        {/if}
        {strip}
        <textarea class="ckeditor" name="product_description_{$obj->mProduct.language[i].language_id}" rows="1" cols="10">
            {$obj->mProduct.description[i]}
        </textarea>
        {/strip}
        {/section}
        <br />
        <br />


    </fieldset>
    

        <input id="button1" type="submit" name="submit_update_product_info" value="Ενημέρωση" /> 
        <input id="button2" type="Reset" value="Επαναφορά" />
        <input id="button1" type="submit" name="submit_remove_from_catalog" value="Αφαίρεση έρευνας" />

        <br />
        <br />

    </form>


