{* smarty *}
{load_presentation_object filename="submitsurvey" assign="obj"}
{config_load file="../../properties/messages_"|cat:$obj->mActiveLang|cat:".txt"}

<section class="row">
    <article class="grid_7">
        <h4>{if $obj->result == 1}{#successful_submission#}{elseif $obj->result == -1}{#already_submitted#}{else}{#fail_submission#}{/if}</h4>
    </article>
</section>