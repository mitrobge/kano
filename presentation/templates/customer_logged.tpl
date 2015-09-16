{* customer_logged.tpl *}
{load_presentation_object filename="customer_logged" assign="obj"}
<h3>O Λογαριασμός μου</h3>
<div class="widget_body">
    <ul>
        <li><a href="#">Ιστορικό Αγορών</a></li>
        <li><a href="#">Wishlist</a></li>
        <li><a href="{$obj->mLinkToAccount}">Στοιχεία συνδρομητή</a></li>
    </ul>
    <a href="{$obj->mLinkToLogout}" class="btn">Έξοδος</a>
</div>
