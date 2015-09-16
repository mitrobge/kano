{* admin_categories.tpl *}
{load_presentation_object filename="admin_categories" assign="obj"}

{literal}
<script language="javascript" type="text/javascript">
$(document).ready(function(){
        
    $("input[name^=\"submit_delete_cat\"]").click(function(){
        var answer = confirm('ΠΡΟΣΟΧΗ: Όλοι οι υποτομείς και όλες οι Έρευνες θα διαγραφούν!');
        return answer // answer is a boolean
    })
})
</script>
{/literal}

<form id="form" enctype="multipart/form-data" method="post" action="{$obj->mLinkToCategoriesAdmin}">
    {if isset($smarty.get.Page) && $smarty.get.Page eq 'Subcategories'}
        <h3>
           Τμήμα: "{if $obj->mCategory.parent_name neq null}{$obj->mCategory.parent_name}>>{/if}{$obj->mCategory.name}"
                &nbsp;(<a href="{$obj->mLinkToSubcategoriesBack}">Πίσω</a>)
        </h3>
    {/if}
    {if $obj->mErrorMessage}
        <p style="color:red"><font size="2">{$obj->mErrorMessage}</font></p>
        <br />
    {/if}
    <br>
    
    
    <fieldset id="admin_add_category">
    <legend>Προσθήκη νέου τμήματος</legend>
    {section name=i loop=$obj->mLanguages}
        <label>{if $smarty.section.i.first}Όνομα{/if}</label>
        <input type="text" name="added_category_name_{$obj->mLanguages[i].language_id}" value="" size="30" />
        {if count($obj->mLanguages) > 1} 
            <img src="images/{$obj->mLanguages[i].language_flag}" alt="{$obj->mLanguages[i].language_name}" width="15" height="15" border="0">
        {/if}
        <br>
    {/section}
    <input id="button1" type="submit" name="submit_add_cat_{if isset($smarty.get.CategoryId)}{$smarty.get.CategoryId}{else}0{/if}" value="Προσθήκη"/>
    </fieldset>
    

    {if count($obj->mCategories) eq 0}
        <p><b>Κανένα θέμα διαθέσιμο!</b></p>
    {else}
        <fieldset id="admin_categories">
        {if !isset($smarty.get.Page) || $smarty.get.Page eq 'Categories'}
            <legend>Τομείς</legend>
        {elseif $smarty.get.Page eq 'Subcategories'}
            <legend>Τμήματα</legend>
        {/if}
        <table>
            <thead>
                <tr>
                    <th width="500"></th>
                    <th width="100"></th>
                    <th width="50"></th>
                </tr>
            </thead>
            <tbody>
            
            {section name=i loop=$obj->mCategories}
                    {if $obj->mEditItem == $obj->mCategories[i].category_id}

                        <tr>
                            <td>
                                <table>
                                {section name=j loop=$obj->mLanguages}
                                <tr><b>Όνομα: </b></tr>
                                    <tr>
                                    <input type="text" size=50 name="category_name_{$obj->mLanguages[j].language_id}" 
                                        value="{$obj->GetCategoryName($obj->mCategories[i].category_id, $obj->mLanguages[j].language_id)}" size="25" />
                                    </br>
                                    {if count($obj->mLanguages) > 1} 
                                        <img src="images/{$obj->mLanguages[j].language_flag}" alt="{$obj->mLanguages[j].language_name}" width="15" height="15" border="0">
                                    {/if}
                                    </tr>
                                    </br>
                                    <tr><b>Περιγραφή: </b></tr>
                                    <tr>
                                      {strip}
                                      <textarea class="ckeditor" name="category_description_{$obj->mLanguages[j].language_id}">
                                      {$obj->GetCategoryDetails($obj->mCategories[i].category_id, $obj->mLanguages[j].language_id)}
                                      </textarea>
                                      {/strip}
                                    </tr>
                                    </br>
                                    </br>
                                {/section}
                                </table>
                                {*<input size="15" name="image_file_{$obj->mCategories[i].category_id}" type="file" value="Μεταφόρτωση" />*}
                            </td>
                            <td>
                            <input id="button1" type="submit" name="submit_update_cat_{$obj->mCategories[i].category_id}"
                                value="Ενημέρωση" />
                            <input id="button2" type="reset" name="reset" value="Επαναφορά πεδίου" />
                            <input id="button2" type="submit" name="cancel" value="Άκυρο" />
                            </td>
                            <td>
                            <a href="{$obj->SubcategoriesLink($obj->mCategories[i].category_id)}"><font size="2"><b>Υποκατηγορίες</b></font></a>
                            <a href="{$obj->ProductsLink($obj->mCategories[i].category_id)}"><font size="2"><b>Έρευνες</b></font></a>
                            </td>
                        </tr>
                {else}
                    <tr>
                        <td>
                        <b><font size="2px">{$obj->mCategories[i].name}</font></b>
                        </td>
                        <td>
                        <input id="button1" type="submit" name="submit_edit_cat_{$obj->mCategories[i].category_id}" 
                            value="Επεξεργασία" />
                        <input id="button1" type="submit" name="submit_delete_cat_{$obj->mCategories[i].category_id}"
                            value="Διαγραφή" />
                        </td>
                        <td> 
                            <a href="{$obj->SubcategoriesLink($obj->mCategories[i].category_id)}"><font size="2"><b>Υποκατηγορίες</b></font></a>
                            <a href="{$obj->ProductsLink($obj->mCategories[i].category_id)}"><font size="2"><b>Έρευνες</b></font></a>
                            {if !isset($smarty.get.Page) || $smarty.get.Page eq 'Categories'}
                                <br><a href="{$obj->mCategories[i].link_to_sort}"><font size="2"><b>Ταξινόμηση</b></font></a>
                            {/if}
                        </td>
                    </tr>
                {/if}
                
            {/section}
            </tbody>
         </table>
        </fieldset>
    {/if}
</form>
