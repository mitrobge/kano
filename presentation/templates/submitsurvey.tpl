{* smarty *}
{load_presentation_object filename="submitsurvey" assign="obj"}

<section class="row">
    <article class="grid_7">
        <h4>{if $obj->result == 1}{#successful_submission#}{elseif $obj->result == -1}{#already_submitted#}
            {elseif $obj->result == -2}{#invalid_email#}{else}{#fail_submission#}{/if}</h4>
    </article>
</section>