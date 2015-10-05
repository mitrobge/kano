{* admin_surveys.tpl *}
{load_presentation_object filename="admin_surveys" assign="obj"}

{literal}
<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    $('#SortingTable').tableDnD({
        onDrop: function(table, row) {
            var data;
            $.getJSON("json/sort_category_children.php", 
                $.tableDnD.serialize(), function(j){
            })
        }
    });
})
</script>
{/literal}

<div id="box">
    <h3>
    Έρευνες της κατηγορίας "{$obj->mCategoryName}"
    </h3>
    <br>
    <a href="{$obj->mLinkToCategories}">Πίσω</a>
    <br>
    <br>
    <h3>
    <a href="{$obj->mLinkToAddProduct}">Προσθήκη νέας Έρευνας</a>
    </h3>
    <br>
    <br>
    {if count($obj->mProducts) eq 0}
        <p><b>Δεν υπάρχουν πιστοποιήσεις σε αυτόν το τμήμα</b></p>
    {else}
        {if count($obj->mProductsPages) > 0}
            {if $obj->mLinkToPreviousPage}
                <a href="{$obj->mLinkToPreviousPage}">Προηγούμενη Σελίδα</a>
            {/if}
            {section name=m loop=$obj->mProductsPages}
                {if $obj->mPageNo eq $smarty.section.m.index_next}
                    <strong>{$smarty.section.m.index_next}</strong>
                {else}
                    <a href="{$obj->mProductsPages[m]}">{$smarty.section.m.index_next}</a>
                {/if}
            {/section}
            {if $obj->mLinkToNextPage}
                <a href="{$obj->mLinkToNextPage}">Επόμενη Σελίδα</a>
            {/if}
            <br>
            <br>
        {/if}
        <table class="tbl_repeat" id="SortingTable">
            <thead>
                <th>Τίτλος</th>
                <th>&nbsp;</th>
            </thead>
            <tbody>
                {section name=i loop=$obj->mProducts}
                <tr>
                    <td>{$obj->mProducts[i].name}</td>
                    <td>      
                    <a href="{$obj->ProductQuestionsLink($obj->mProducts[i].survey_id,1,null)}"><font size="2"><b>Ερωτήσεις KANO</b></font></a></br>
                    <a href="{$obj->ProductDetailsLink($obj->mProducts[i].survey_id,1,null)}"><font size="2"><b>Στοιχεία Έρευνας</b></font></a>
                    </td>
                </tr>
                {/section}
            </tbody>
        </table>
    {/if}
</div>
