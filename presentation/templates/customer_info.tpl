{* customer_info.tpl *}
{load_presentation_object filename="customer_info" assign="obj"}

{if $obj->mCustomerIsLoggedIn}
   <li><a href="{$obj->mLinkToLogout}">Logout</a></li>
   <li class="registration"><a id="to_customer_account" href="{$obj->mLinkToAccount}">User Profile</a></li>
{else}
    <li><a class="login_btn" id="login_btn" href="#login">Sign-in</a></li>
    <li class="registration"><a href="{$obj->mLinkToAccount}">Register</a></li>
{/if}
