{* admin_menu.tpl *}
{load_presentation_object filename="admin_menu" assign="obj"}
<div id="topmenu">
    <ul>
    {if $obj->mLinkToCategoriesAdmin}<li><a href="{$obj->mLinkToCategoriesAdmin}">My Surveys</a></li>{/if}
    {if $obj->mLinkToFilesAdmin}<li><a href="{$obj->mLinkToFilesAdmin}">Διαχείριση αρχείων</a></li>{/if}
    {if $obj->mLinkToAdministratorsAdmin}<li><a href="{$obj->mLinkToAdministratorsAdmin}">Διαχειριστές</a></li>{/if}
    {if $obj->mLinkToMyAccount}<li><a href="{$obj->mLinkToMyAccount}">Ο λογαριασμός μου</a></li>{/if}
    <li><a href="{$obj->mLinkToLogout}">Αποσύνδεση</a></li>
    </ul>
</div>
