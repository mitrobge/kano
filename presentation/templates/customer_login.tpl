{* customer_login.tpl *}
{load_presentation_object filename="customer_login" assign="obj"}
{if $obj->mErrorMessage}
    {literal}
    <script type="text/javascript">
    $(document).ready(function() {
        $("#login_btn").trigger('click');
    });
    </script>
    {/literal}
{/if}
<div id="login">
    <form id="login_form" method="post" action="{$obj->mLinkToLogin}">
        {if $obj->mErrorMessage}
            <label class="error">{$obj->mErrorMessage}</label>
        {/if}

        <fieldset>
        <label for="text">Username:</label>
        <input type="text" class="text" name="email" value="{$obj->mEmail}" />
        </fieldset>
        <fieldset>
        <label for="text">Password:</label>
        <input type="password" class="text" name="password" />
        </fieldset>
        <a href="{$obj->mLinkToRecoverPassword}">Ξεχάσατε τον κωδικό σας;</a>
        {*<a href="#" class="btn">login</a>*}
        <input class="btn" style="width:90px" type="submit" name="Login" value="login" />
    </form>	
</div>
