{* admin_administrators.tpl *}
{load_presentation_object filename="admin_administrators" assign="obj"}

{literal}
<script type="text/javascript">
<!--
function expandMenu(callingElt, elt) {
    var obj = document.getElementById(elt);
    if (obj.style.display == 'none')
    {
        obj.style.display = 'block';
    }
    else if (obj.style.display == 'block')
    {
        obj.style.display = 'none';
    }
}
//-->
</script>
{/literal}

<br>
<a href="javascript::void(0)" onclick='expandMenu(this, "new_administrator");'>Προσθήκη Διαχειριστή</a>
<br>
<br>

<div id="new_administrator" style="display:none;">
    {if $obj->mErrorMessage}
        <p style="color:red">ERROR: {$obj->mErrorMessage}</p>
        <br>
    {/if}
    <form id="form" method="post" action="">
        <fieldset id="add_administrator">
        <legend>Προσθήκη Διαχειριστή</legend>
        <label>Όνομα</label>
        <input type="text" name="admin_first_name" value="{$obj->mNewAdmin.first_name}">
        <br />
        <label>Επίθετο</label>
        <input type="text" name="admin_last_name" value="{$obj->mNewAdmin.last_name}">
        <br />
        <label>Διεύθυνση Email</label>
        <input type="text" name="admin_email" value="{$obj->mNewAdmin.email}">
        <br />
        <label>Κωδικός</label>
        <input type="password" name="admin_password" value="{$obj->mNewAdmin.password}">
        <br />
        <label>Επιβεβαίωση Κωδικού</label>
        <input type="password" name="admin_password_confirm" value="{$obj->mNewAdmin.password_confirm}">
        <br />
        <p><input id="button1" type="submit" name="submit_add_admin_0" value="Προσθήκη" />
           <input id="button2" type="reset" name="reset" value="Επαναφορά" />
        </p>
        </fieldset>
    </form>
    <br>
</div>

{if $obj->mErrorMessage}
    {literal}
    <script language=javascript>expandMenu(this, "new_administrator")</script>
    {/literal}
{/if}

<div id="box">
    <form id="form" method="post" action="">
        <h3>Διαχειριστές</h3>
        <table width="100%">
            <thead>
                <th width="40">ID</th>
                <th>Όνομα</th>
                <th>Διεύθυνση Email</th>
                <th>Δημιουργήθηκε</th>
                <th>Τελευταία σύνδεση</th>
                <th>Κατάσταση</th>
                <th>&nbsp;</th>
            </thead>
            <tbody>
            {section name=i loop=$obj->mAdministrators}
            <tr>
                <td class="a-center">{$obj->mAdministrators[i].administrator_id}</td>
                <td>{$obj->mAdministrators[i].last_name} {$obj->mAdministrators[i].first_name}</td>
                <td>{$obj->mAdministrators[i].email}</td>
                <td>{$obj->mAdministrators[i].created_on|date_format:"%d-%m-%Y %T"}</td>
                <td>{$obj->mAdministrators[i].last_login|date_format:"%d-%m-%Y %T"}</td>
                <td>{$obj->mAdministrators[i].status}</td>
                <td class="a-center">
                    <nobr><a href="{$obj->mAdministrators[i].link_to_administrator_details}">Λεπτομέρειες</a>
                    {if $obj->mAdministrators[i].administrator_id neq $obj->mMyAdministratorId}
                        <input style="width: 100px;" id="button1" type="submit" name="submit_delete_admin_{$obj->mAdministrators[i].administrator_id}"
                            value="Διαγραφή" />
                    {else}
                        <input style="width: 100px;" type="submit" name="submit_delete_admin_{$obj->mAdministrators[i].administrator_id}"
                            value="Διαγραφή" disabled="disabled"/>
                    {/if}
                    </nobr>
                </td>
            </tr>
            {/section}
            </tbody>
        </table>
    </form>
</div>
