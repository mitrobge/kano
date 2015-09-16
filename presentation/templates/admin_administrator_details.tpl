{* admin_administrator_details.tpl *}
{load_presentation_object filename="admin_administrator_details" assign="obj"}

{if !isset($smarty.get.ChangePassword)}
    <h3>
    <a href="{$obj->mLinkToAdministrators}">Όλοι οι διαχειριστές</a>
    </h3>
    <br>
    <br>
    <a href="{$obj->mLinkToChangePassword}">Αλλαγή κωδικού</a>
    <br>
    <br>
{else}
    <h3>
    <a href="{$obj->mLinkToAdministratorDetails}">Λεπτομέρειες διαχειριστή</a>
    </h3>
{/if}

{if $obj->mErrorMessage}
<p style="color:red">ERROR: {$obj->mErrorMessage}</p>
{/if}

<form id="form" method="post" action="">
    {if isset($smarty.get.ChangePassword)}
        <fieldset id="admin_change_pass">
        <legend>Αλλαγή κωδικού</legend>
        {if $obj->mAdministrator.administrator_id eq $obj->mMyAdministratorId}
            <label>Τρέχον κωδικός : </label> 
                <input type="password" name="admin_existing_password" value="">
            <br />
        {/if}
        <label>Νέος κωδικός : </label> 
            <input type="password" name="admin_new_password" value="">
        <br />
        <label>Επιβεβαίωση νέου κωδικού: </label>
            <input type="password" name="admin_confirm_new_password" value="">
        <br />
        </fieldset>
    {else}
        <fieldset id="admin_info">
        <legend>Πληροφορίες Διαχειριστή</legend>
        <label>Δημηιουργήθηκε: </label>
            {$obj->mAdministrator.created_on}
        <br />
        <label>Τελ. σύνδεση: </label>
            {$obj->mAdministrator.last_login}
        <br />
        <label>Όνομα: </label> 
            <input type="text" name="admin_first_name" value="{$obj->mAdministrator.first_name}">
        <br />
        <label>Επίθετο: </label> 
            <input type="text" name="admin_last_name" value="{$obj->mAdministrator.last_name}">
        <br />
        <label>Διεύθυνση Email: </label>
            <input type="text" name="admin_email" value="{$obj->mAdministrator.email}">
        <br />
        {if $obj->mHasPermission} 
            <label>Κατάσταση: </label>
                <select name="admin_status">
                    {html_options options=$obj->mAdministratorStatusOptions
                        selected=$obj->mAdministrator.status}
                </select>
            <br />
            {section name=i loop=$obj->mAvailablePermissions}
                {* Generate a new select tag? *}
                {if $smarty.section.i.first ||
                    $obj->mAvailablePermissions[i].name !==
                    $obj->mAvailablePermissions[i.index_prev].name}
                    {if !$smarty.section.i.first}
                        <br>
                    {/if}
                    <br>
                    <label style="width:220px">{$obj->mAvailablePermissions[i].name} : </label>
                {/if}
                {assign var=permission_id value=$obj->mAvailablePermissions[i].permission_id}
                <input type="checkbox" name="permission[]" 
                    value="{$obj->mAvailablePermissions[i].permission_id}" 
                        {if isset($obj->mAdministrator.permissions_ids_flipped.$permission_id)}checked="yes"{/if}/>&nbsp 
            {/section}
            <br />
        {else}
            <input type="hidden" name="admin_status" value="{$obj->mAdministrator.status}">
            <input type="hidden" name="permission[]" value="{$obj->mAdministrator.permissions_ids}">
        {/if}
        </fieldset>
    {/if}
    
    {if isset($smarty.get.ChangePassword)}
        <input type="hidden" name="admin_email" value="{$obj->mAdministrator.email}">
    {else}
        <input type="hidden" name="admin_created_on" value="{$obj->mAdministrator.created_on}">
        <input type="hidden" name="admin_last_login" value="{$obj->mAdministrator.last_login}">
    {/if}
    
    <input id="button1" type="submit" name="submit_save_changes" value="Αποθήκευση αλλαγών" />
    <input id="button2" type="Reset" value="Επαναφορά" />
    {if !isset($smarty.get.ChangePassword)}
        {if $obj->mAdministrator.administrator_id neq $obj->mMyAdministratorId}
            <input id="button1" type="submit" name="submit_delete_admin" value="Διαγραφή" />
        {else}
            <input type="submit" name="submit_delete_admin" value="Διαγραφή" disabled="disabled"/>
        {/if}
    {/if}
</form>
