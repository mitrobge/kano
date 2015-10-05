{* smarty *}
{load_presentation_object filename="allsurveys" assign="obj"}

<section class="row">
    <article class="grid_8">
        <p>{#active_survey_num#}: {$obj->mSurveys|@count}</p>
        <table>
            <thead>
            <tr>
                <th scope="col">{#survey#}</th>
                <th scope="col">{#descr#}</th>
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
