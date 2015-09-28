{* admin_category_attributes.tpl *}
{load_presentation_object filename="admin_categories" assign="obj"}
<form id="form" method="post" action="{$obj->mLinkToCategoryAttributesAdmin}">
    <h3>
       Χαρακτηριστικά κατηγορίας "{$obj->mCategory.name}"
            &nbsp;(<a href="{$obj->mLinkToCategoriesAdmin}">Πίσω στις κατηγορίες</a>)
    </h3>
    <br>
    {if $obj->mWarningMessage}
        <p style="color:orange"><font size="2">{$obj->mWarningMessage}</font></p>
        <br />
    {/if}
    {if $obj->mErrorMessage}
        <p style="color:red"><font size="2">{$obj->mErrorMessage}</font></p>
        <br />
    {/if}
    <fieldset id="admin_add_attribute">
    <legend>Προσθήκη Χαρακτηριστικού</legend>
    {section name=i loop=$obj->mLanguages}
        <label>{if $smarty.section.i.first}Όνομα: {/if}</label>
        <input type="text" name="added_attribute_name_{$obj->mLanguages[i].language_id}" value="" size="30" />
        {if count($obj->mLanguages) > 1} 
            <img src="images/{$obj->mLanguages[i].language_flag}" alt="{$obj->mLanguages[i].language_name}" width="15" height="15" border="0" />
        {/if}
        <br>
    {/section}
    <input id="button1" type="submit" name="submit_add_attr_0" value="Προσθήκη" />
    <br />
    {if count($obj->mOtherAttributes)}
        <label>Εκχώρηση υπάρχοντος: </label>
        <select name="assigned_attribute_id"> 
            {section name=i loop=$obj->mOtherAttributes}
            <option value="{$obj->mOtherAttributes[i].attribute_id}">{$obj->mOtherAttributes[i].attribute_name}</option>
            {/section}
        </select>
        <input id="button1" type="submit" name="submit_assign_attr_0" value="Εκχώρηση" />
    {/if}
    </fieldset>
    {if count($obj->mCategory.attributes) eq 0}
        <p><b>Δεν υπάρχουν χαρακτηριστικά!</b></p>
    {else}
        <fieldset id="admin_category_attributes">
        <legend>Χαρακτηριστικά</legend>
        <table>
            <thead>
                <th width="150">Όνομα χαρακτηριστικού</th>
                <th width="100">Ενέργειες</th>
            </thead>
            <tbody>
            {section name=i loop=$obj->mCategory.attributes}
                {if $obj->mEditItem == $obj->mCategory.attributes[i].attribute_id}
                    <tr>
                        <td>
                            <table>
                                {section name=j loop=$obj->mLanguages}
                                    <tr>
                                    <input type="text" name="attribute_name_{$obj->mLanguages[j].language_id}" 
                                        value="{$obj->GetAttributeName($obj->mCategory.attributes[i].attribute_id, 
                                            $obj->mLanguages[j].language_id)}" size="20" />
                                    {if count($obj->mLanguages) > 1} 
                                        <img src="images/{$obj->mLanguages[j].language_flag}" alt="{$obj->mLanguages[j].language_name}" width="15" height="15" border="0" />
                                    {/if}
                                    </tr>
                                {/section}
                            </table>
                        </td>
                        <td>
                        <input id="button1" type="submit" name="submit_update_attr_{$obj->mCategory.attributes[i].attribute_id}"
                            value="Ενημέρωση" />
                        <input id="button1" type="reset" name="reset"
                            value="Επαναφορά" />
                        <input id="button1" type="submit" name="cancel"
                            value="Άκυρο" />
                        </td>
                    </tr>
                {else}
                    <tr>
                        <td>{$obj->mCategory.attributes[i].attribute_name}</td>
                        <td>
                        <input id="button1" type="submit" name="submit_edit_attr_{$obj->mCategory.attributes[i].attribute_id}" 
                            value="Τροποποίηση" />
                        <input id="button1" type="submit" name="submit_delete_attr_{$obj->mCategory.attributes[i].attribute_id}"
                            value="Διαγραφή" />
                        </td>
                    </tr>
                {/if}
            {/section}
            </tbody>
        </table>
        </fieldset>
    {/if}
</form>
