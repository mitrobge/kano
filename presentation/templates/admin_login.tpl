{* admin_login.tpl *}
{load_presentation_object filename="admin_login" assign="obj"}
 <div id="box">
    <h3 id="adduser">Σύνδεση</h3>
{if $obj->mLoginMessage neq ""}
    <p style="color:red">{$obj->mLoginMessage}</p>
{/if}
    <form id="form" action="{$obj->mLinkToAdmin}" method="post">
    <fieldset id="personal">
        <label for="email">Διεύθυνση Email : </label>
        <input name="email" id="email" type="text" value="{$obj->mEmail}" tabindex="2" />
        <br />
        <label for="pass">Κωδικός : </label>
        <input name="password" id="pass" type="password" tabindex="2" />
        <br />
    </fieldset>
        <input id="button1" type="submit" name="submit" value="Σύνδεση" /> 
    </form>
</div>
