{* smarty *}
{load_presentation_object filename="survey" assign="obj"}

<section class="row">
    <article class="grid_12">
        <h4>{if $obj->mActiveLang eq "gr"}Έρευνα: {else}Survey:{/if} {$obj->survey.name}</h4>
        {*<table>
            <thead>
            <tr>
                <th scope="col">Έρευνα</th>
                <th scope="col">Περιγραφή</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$obj->mSurveys item=item}
                <tr><td>{$item.name}</td>
                    *}{*<td><a href="{$obj->mLinks.toSurvey}?sid={$item.survey_id}">{$item.description}</a></td>*}{*
                    <td><a href="{$obj->links[$item.survey_id]}">{$item.description}</a></td>
                </tr>
            {/foreach}
            </tbody>
        </table>*}
    </article>
</section>