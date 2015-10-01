{* smarty *}
{load_presentation_object filename="survey" assign="obj"}

<script type="text/javascript" src="assets/js/survey.js"></script>

<section class="row">
    <article class="grid_7">
        <h4><strong>{#survey#}</strong> {$obj->data[0].name}</h4>
        <hr>
    </article>
</section>
{if $obj->isCss == 0}
    <section class="row">
        <article class="grid_6">
            <form id="submitsurveyForm" name="submitsurveyForm" action="{$obj->mLinkToSubmitSurvey}" method="post" onsubmit="return validateEmail(this)">
                <input type="hidden" name="sid" value="{$obj->data[0].id}"/>
                {foreach from=$obj->data item=item}

                    <p><strong>{if $item.is_positive}{$item.qid}-1. {else}{$item.qid}-2. {/if}{$item.question}</strong></p>
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
                    {if $item.is_positive eq 0}<hr>{/if}
                {/foreach}

                <fieldset>
                    <label for="email"><strong>{#email#}:* </strong></label>
                    <input type="email" name="email" id="email" placeholder="Email" tabindex="1" pattern="[0-9\-.\(\)\+\s]+" />
                </fieldset>
                <fieldset>
                    <input class="btn" type="submit" name="submit" id="submitbtn" tabindex="14" value="{#submit#}" class="first" />
                </fieldset>

            </form>
        </article>
    </section>
{else}
    <section class="row">
        <article class="grid_6">
            <form id="submitsurveyForm" name="submitsurveyForm" action="{$obj->mLinkToSubmitSurvey}" method="post" onsubmit="return validateEmail(this)">
                <input type="hidden" name="sid" value="{$obj->data[0].id}"/>
                {foreach from=$obj->data item=item}

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
                    {if $item.is_positive eq 0}<hr>{/if}
                {/foreach}

                <fieldset>
                    <label for="email"><strong>{#email#}:* </strong></label>
                    <input type="email" name="email" id="email" placeholder="Email" tabindex="1" pattern="[0-9\-.\(\)\+\s]+" />
                </fieldset>
                <fieldset>
                    <input class="btn" type="submit" name="submit" id="submitbtn" tabindex="14" value="{#submit#}" class="first" />
                </fieldset>

            </form>
        </article>
    </section>
{/if}