{* smarty *}
{load_presentation_object filename="survey" assign="obj"}

<section class="row">
    <article class="grid_7">
        <h4>{if $obj->mActiveLang eq "gr"}Έρευνα: {else}Survey:{/if} {$obj->data[0].name}</h4>
    </article>
</section>
<section class="row">
    <article class="grid_12">
        <form name="submitsurveyForm" action="{$obj->mLinkToSubmitSurvey}" method="post">
            <input type="hidden" name="sid" value="{$obj->data[0].id}"/>
            {foreach from=$obj->data item=item}


                <table>
                    <tr><td colspan="5">{$item.question}</td></tr>
                    <tr>
                        {*{if $item.is_positive eq "true"}1{else}0{/if}*}
                        <td><div class="radio"><input type="radio" name="q{$item.qid}{$item.is_positive}" value="1" checked>Μου αρέσει έτσι</div></td>
                        <td><div class="radio"><input type="radio" name="q{$item.qid}{$item.is_positive}" value="2">Έτσι πρέπει να είναι</div></td>
                        <td><div class="radio"><input type="radio" name="q{$item.qid}{$item.is_positive}" value="3">Είμαι Ουδέτερος</div></td>
                        <td><div class="radio"><input type="radio" name="q{$item.qid}{$item.is_positive}" value="4">Μπορώ να το ανεχθώ</div></td>
                        <td><div class="radio"><input type="radio" name="q{$item.qid}{$item.is_positive}" value="5">Δεν μου αρέσει έτσι</div></td>
                    </tr>
                </table>
            {/foreach}

            {*    <table>
                    <tr>*}
            <fieldset id="personal">
                <label for="email">Διεύθυνση Email : </label>
                <input name="email" id="email" type="text" value="" size="10" tabindex="2" />
            </fieldset>
            <input id="button1" type="submit" name="submit" value="Αποστολή" />
            {* </tr>
         </table>*}

        </form>
    </article>
</section>
