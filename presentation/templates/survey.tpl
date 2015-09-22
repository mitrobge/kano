{* smarty *}
{load_presentation_object filename="survey" assign="obj"}

<section class="row">
    <article class="grid_7">
        <h4>{if $obj->mActiveLang eq "gr"}Έρευνα: {else}Survey:{/if} {$obj->data[0].name}</h4>
    </article>
</section>
<section class="row">
    <article class="grid_6">
        <form name="submitsurveyForm" action="{$obj->mLinkToSubmitSurvey}" method="post">
            <input type="hidden" name="sid" value="{$obj->data[0].id}"/>
            {foreach from=$obj->data item=item}

                <p>{$item.question}</p>
                <fieldset>
                    <div class="radio">
                    <span>
                        <input id="r1" type="radio" tabindex="11" name="q{$item.qid}{$item.is_positive}" value="1" checked>
                        <label for="r1" onclick="">Μου αρέσει έτσι</label>
                    </span>
                    <span>
                        <input id="r2" type="radio" tabindex="11" name="q{$item.qid}{$item.is_positive}" value="2">
                        <label for="r2" onclick="">Έτσι πρέπει να είναι</label>
                    </span>
                    <span>
                        <input id="r3" type="radio" tabindex="11" name="q{$item.qid}{$item.is_positive}" value="3">
                        <label for="r3" onclick="">Είμαι Ουδέτερος</label>
                    </span>
                    <span>
                        <input id="r4" type="radio" tabindex="11" name="q{$item.qid}{$item.is_positive}" value="2">
                        <label for="r4" onclick="">Μπορώ να το ανεχθώ</label>
                    </span>
                    <span>
                        <input id="r4" type="radio" tabindex="11" name="q{$item.qid}{$item.is_positive}" value="3">
                        <label for="r4" onclick="">Δεν μου αρέσει έτσι</label>
                    </span>
                    </div>
                </fieldset>
            {/foreach}

            <fieldset>
                <label for="email">Διεύθυνση Email :</label>
                <input type="text" name="email" id="email" tabindex="1" />
            </fieldset>
            <fieldset>
                <input type="submit" name="submit" id="submitbtn" tabindex="14" value="Αποστολή" class="first" />
            </fieldset>

        </form>
    </article>
</section>
