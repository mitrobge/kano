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
            alert("{/literal}{#invalid_email#}{literal}");
            form.email.focus();
            return false;
        }
    }

</script>
{/literal}

<section class="row">
    <article class="grid_7">
        <h4>{#survey#}</h4>
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
                        <input id="r{$item.qid}{$item.is_positive}1" type="radio" tabindex="11" name="q{$item.qid}{$item.is_positive}" value="1">
                        <label for="r{$item.qid}{$item.is_positive}1" onclick="">{#ans1#}</label>
                    </span>
                    <span>
                        <input id="r{$item.qid}{$item.is_positive}2" type="radio" tabindex="11" name="q{$item.qid}{$item.is_positive}" value="2">
                        <label for="r{$item.qid}{$item.is_positive}2" onclick="">{#ans2#}</label>
                    </span>
                    <span>
                        <input id="r{$item.qid}{$item.is_positive}3" type="radio" tabindex="11" name="q{$item.qid}{$item.is_positive}" value="3" checked>
                        <label for="r{$item.qid}{$item.is_positive}3" onclick="">{#ans3#}</label>
                    </span>
                    <span>
                        <input id="r{$item.qid}{$item.is_positive}4" type="radio" tabindex="11" name="q{$item.qid}{$item.is_positive}" value="4">
                        <label for="r{$item.qid}{$item.is_positive}4" onclick="">{#ans4#}</label>
                    </span>
                    <span>
                        <input id="r{$item.qid}{$item.is_positive}5" type="radio" tabindex="11" name="q{$item.qid}{$item.is_positive}" value="5">
                        <label for="r{$item.qid}{$item.is_positive}5" onclick="">{#ans5#}</label>
                    </span>
                    </div>
                </fieldset>
            {/foreach}

            <fieldset>
                <label for="email">{#email#}</label>
                <input type="text" name="email" id="email" tabindex="1" />
            </fieldset>
            <fieldset>
                <input type="submit" name="submit" id="submitbtn" tabindex="14" value="Αποστολή" class="first" />
            </fieldset>

        </form>
    </article>
</section>
