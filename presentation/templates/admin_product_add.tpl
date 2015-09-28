{* admin_product_add.tpl *}
{load_presentation_object filename="admin_product_add" assign="obj"}

{literal}
<!-- required plugins --> 
<script type="text/javascript" src="scripts/date.js"></script> 
<script type="text/javascript" src="scripts/jquery.dateFormat-1.0.js"></script> 
<!--[if IE]><script type="text/javascript" src="scripts/bgiframe_2.1.1/jquery.bgiframe.min.js"></script><![endif]--> 
       
<!-- jquery.datePicker.js --> 
<script type="text/javascript" src="scripts/jquery.datePicker.js"></script> 
       
<!-- datePicker required styles --> 
<link rel="stylesheet" type="text/css" media="screen" href="styles/datePicker.css"> 

<!-- page specific scripts --> 
<script type="text/javascript" charset="utf-8"> 
    $(function(){
        $('.date-pick').datePicker({startDate:$.format.date(new Date(), "dd/MM/yyyy"),endDate: '01/01/2045'});
    });
</script> 

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
        $("select#category_list").change(function(){
            $.getJSON("json/get_category_products.php",{category_id: $(this).val()}, function(j){
                var options = '';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
                }
                $("#tmp_groupset_list").html(options);
                //$('#groupset_list option:first').attr('selected', 'selected');
            })
        })
        
        $("input[name=\"submit_add_product\"]").click(function(){
            $("#groupset_list option").attr("selected", "selected");
        })
    })
</script>
{/literal}

<form id="form" method="post" action="">
  <h3>
    <a href="{$obj->mLinkToProductsAdmin}">Πίσω στα Προϊόντα</a>
    <br>
    <br>
  </h3>
    {if $obj->mErrorMessage}<p style="color:red">{$obj->mErrorMessage}</p>{/if}
    <fieldset id="admin_add_product">
    <legend>Προσθήκη Προϊόντος</legend>
    {if !isset($smarty.get.CategoryId)}
        <legend>Προσθήκη Προϊόντος</legend>
        <label>Κατηγορία:</label>
            <select name="product_category_id">
            <option value="" SELECTED>Επιλέξτε Κατηγορία ...</option>
                {section name=i loop=$obj->mCategories}
                    <option value="{$obj->mCategories[i].category_id}"
                        {if $obj->mCategories[i].category_id eq $obj->mProduct.category_id}SELECTED{/if}>
                            {$obj->mCategories[i].name|replace:"-":"&nbsp;" $obj->mCategories[i].name}</option>
                {/section}
            </select>&nbsp;<span class="input_required">*</span>
        <br />
        <br />
    {/if}
    <label>Κωδικός ERP: </label>
        <input type="text" name="product_erp_code"
            value="{$obj->mProduct.erp_code}" size="16" />
    <br />
    {section name=i loop=$obj->mProduct.name}
        <label>{if $smarty.section.i.first}Όνομα{/if}</label>
        <input type="text" name="product_name_{$obj->mProduct.language[i].language_id}"
              value="{$obj->mProduct.name[i]}" size="20" />
        {if count($obj->mLanguages) > 1} 
            <img src="images/{$obj->mProduct.language[i].language_flag}" alt="{$obj->mProduct.language[i].language_name}" width="15" height="15" border="0" />
        {/if}
        <br />
    {/section}
    <br />
    <label>Κατασκευαστής: </label> 
        <select name="product_manufacturer_id"> 
            <option value="">Επιλέξτε...</option>
            {section name=i loop=$obj->mManufacturers}
            <option value="{$obj->mManufacturers[i].manufacturer_id}" 
                {if $obj->mManufacturers[i].manufacturer_id eq $obj->mProduct.manufacturer_id} SELECTED {/if}>
            {$obj->mManufacturers[i].manufacturer_name}</option>
            {/section}
        </select>
    <br />
    <br />
    {section name=i loop=$obj->mProduct.introduction}
        <label>{if $smarty.section.i.first}Εισαγωγή :{/if}</label>
        {strip}
        <textarea name="product_introduction_{$obj->mProduct.language[i].language_id}" rows="3" cols="50">
          {$obj->mProduct.introduction[i]}
        </textarea>
        {if count($obj->mProduct.introduction) > 1} 
            <img src="images/{$obj->mProduct.language[i].language_flag}" alt="{$obj->mProduct.language[i].language_name}" width="15" height="15" border="0" />
        {/if}
        {/strip}
    {/section}
    <br />
    <br />
    {section name=i loop=$obj->mProduct.description}
        <label>{if $smarty.section.i.first}Περιγραφή :{/if}</label>
        {strip}
        <textarea name="product_description_{$obj->mProduct.language[i].language_id}" rows="3" cols="50">
          {$obj->mProduct.description[i]}
        </textarea>
        {if count($obj->mProduct.description) > 1} 
            <img src="images/{$obj->mProduct.language[i].language_flag}" alt="{$obj->mProduct.language[i].language_name}" width="15" height="15" border="0" />
        {/if}
        {/strip}
    {/section}
    <br />
    <br />
    {section name=i loop=$obj->mProduct.comments}
        <label>{if $smarty.section.i.first}Σχόλια: {/if}</label>
        {strip}
        <textarea name="product_comments_{$obj->mProduct.language[i].language_id}" rows="3" cols="40">
            {$obj->mProduct.comments[i]}
        </textarea>
        {if count($obj->mProduct.comments) > 1} 
            <img src="images/{$obj->mProduct.language[i].language_flag}" alt="{$obj->mProduct.language[i].language_name}" width="15" height="15" border="0" />
        {/if}
        {/strip}
    {/section}
    <br />
    <br />
    <label>Τιμή: </label>
        <input type="text" name="product_price"
            value="{$obj->mProduct.price}" size="5" />
    <br />
    <br />
    <label>Ογκώδες: </label>
        <input type="checkbox" name="is_bulky" {if $obj->mProduct.isbulky}CHECKED{/if}>
    <br />

    {if $obj->mCategoryIsGroup}
        <legend>Δημιουργία groupset</legend>
        <br />

        <table cellpadding="5" cellspacing="5">
        <tbody>
        <tr>
            <td colspan="2">
                <select id="category_list" name="category_id"> 
                    <option value="">Επιλέξτε κατηγορία...</option>
                    {section name=i loop=$obj->mCategories}
                    {if !$obj->mCategories[i].is_group}
                    <option value="{$obj->mCategories[i].category_id}">
                        {$obj->mCategories[i].name|replace:"-":"&nbsp;" $obj->mCategories[i].name}</option>
                    {/if}    
                    {/section}
                </select>
            </td>
            <td colspan="2">
                    <select id="tmp_groupset_list" multiple="multiple" size="10" name="tmp_groupset_list">
                    </select>
            </td>
            <td colspan="2">
                <select id="groupset_list" multiple="multiple" size="10" name="groupset_list[]">
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><input id="moveright" type="button" value="Προσθήκη" onclick="move_list_items('tmp_groupset_list','groupset_list');" /></td>
            <td><input id="moverightall" type="button" value="Προσθήκη όλων" onclick="move_list_items_all('tmp_groupset_list','groupset_list');" /></td>
            <td><input id="moveleft" type="button" value="Αφαίρεση" onclick="move_list_items('groupset_list','tmp_groupset_list');" /></td>
            <td><input id="moveleftall" type="button" value="Αφαίρεση όλων" onclick="move_list_items_all('groupset_list','tmp_groupset_list');" /></td>
        </tr>
        </tbody>
        </table>
    {/if}
    <br />
    <label>Προσφορά: </label>
    <input type="checkbox" name="promotion_offer" {if isset($smarty.post.promotion_offer)}checked{/if}>
    <label>από</label>
    <input name="promotion_offer_start_date" id="promotion_offer_start_date" class="date-pick" value="{$obj->mPromotionOfferStartDate}">
    <label>εώς</label>
    <input name="promotion_offer_end_date" id="promotion_offer_end_date" class="date-pick" value={if $obj->mPromotionOfferEndDate}{$obj->mPromotionOfferEndDate}{else}""{/if}>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <label>Αρχική σελίδα: </label>
    <input type="checkbox" name="promotion_frontpage" {if isset($smarty.post.promotion_frontpage)}checked{/if}>
    <label>από</label>
    <input name="promotion_frontpage_start_date" id="promotion_frontpage_start_date" class="date-pick" value="{$obj->mPromotionFrontpageStartDate}">
    <label>εώς</label>
    <input name="promotion_frontpage_end_date" id="promotion_frontpage_end_date" class="date-pick" value={if $obj->mPromotionFrontpageEndDate}{$obj->mPromotionFrontpageEndDate}{else}""{/if}>
    <br/>
    <br/>
    </fieldset>
    <input id="button1" type="submit" name="submit_add_product" value="Προσθήκη Προϊόντος" />
    <input id="button2" type="reset" value="Επαναφορά"/>
</form>
