{* smarty *}
{load_presentation_object filename="survey" assign="obj"}

{literal}
    <script language="JavaScript" type="text/javascript">

        function validateEmail(form)
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if(form.email.value.match(mailformat))
            {
                form.email.focus();
                return true;
            }
            else
            {
                {/literal}
                {if $obj->mActiveLang eq "gr"}
                {literal}
                alert("Λάθος διεύθυνση email!");
                {/literal}
                {else}
                {literal}
                alert("You have entered an invalid email address!");
                {/literal}
                {/if}
                {literal}
                form.email.focus();
                return false;
            }
        }

    </script>
{/literal}

<section class="row">
    <article class="grid_7">
        <h4>{if $obj->mActiveLang eq "gr"}Έρευνα: {else}Survey:{/if} {$obj->data[0].name}</h4>
    </article>
</section>
<section class="row">
    <article class="grid_6">
        <form id="form1" name="submitsurveyForm" action="{$obj->mLinkToSubmitSurvey}" method="post" onsubmit="return validateEmail(this)">
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
