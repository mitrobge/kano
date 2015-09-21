{* smarty *}
{load_presentation_object filename="survey" assign="obj"}

<section class="row">
    <article class="grid_7">
        <h4>{if $obj->mActiveLang eq "gr"}Έρευνα: {else}Survey:{/if} {$obj->data[0].name}</h4>
    </article>
</section>

<form name="submitsurveyForm" action="submitsurvey" method="post">
    {foreach from=$obj->data item=item}
        <section class="row">
            <article class="grid_12">
                <table>
                    <tr><td colspan="5">{$item.question}</td></tr>
                    <tr>
                        {*{if $item.is_positive eq "true"}1{else}0{/if}*}
                        <td><input type="radio" name="q{$item.qid}{$item.is_positive}" value="1" checked>Μου αρέσει έτσι</td>
                        <td><input type="radio" name="q{$item.qid}{$item.is_positive}" value="1">Έτσι πρέπει να είναι</td>
                        <td><input type="radio" name="q{$item.qid}{$item.is_positive}" value="1">Είμαι Ουδέτερος</td>
                        <td><input type="radio" name="q{$item.qid}{$item.is_positive}" value="1">Μπορώ να το ανεχθώ</td>
                        <td><input type="radio" name="q{$item.qid}{$item.is_positive}" value="1">Δεν μου αρέσει έτσι</td>
                    </tr>
                </table>
            </article>
        </section>
    {/foreach}
</form>
