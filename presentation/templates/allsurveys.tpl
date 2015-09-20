{* smarty *}
{load_presentation_object filename="allsurveys" assign="obj"}

<section class="row">
    <article class="grid_7">
        <h4>{if $obj->mActiveLang eq "gr"}Αριθμός ενεργών ερευνών: {else}Number of active surveys:{/if} {$obj->mSurveys|@count}</h4>
        <table>
            <thead>
            <tr>
                <th scope="col">Έρευνα</th>
                <th scope="col">Περιγραφή</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$obj->mSurveys item=item}
                <tr><td>{$item.name}</td>
                    {*<td><a href="{$obj->mLinks.toSurvey}?sid={$item.survey_id}">{$item.description}</a></td>*}
                    <td><a href="{$obj->links[$item.survey_id]}">{$item.description}</a></td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </article>
</section>