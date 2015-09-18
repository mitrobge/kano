{* smarty *}
{load_presentation_object filename="allsurveys" assign="obj"}

{if $obj->mActiveLang eq "gr"}Αριθμός ενεργών ερευνών{else}Number of active surveys:{/if} {$obj->mSurveys|@count}

<table>
    <tr><td>Έρευνα</td><td>Περιγραφή</td></tr>
<ul>
    {foreach from=$obj->mSurveys item=item}
        <tr><td>{$item.name}</td>
            {*<td><a href="{$obj->mLinks.toSurvey}?sid={$item.survey_id}">{$item.description}</a></td>*}
            <td><a href="{$obj->mLinks.toSurvey}?sid={$item.survey_id}">{$item.description}</a></td>
            {*Link::ToCluster($this->mCustomerClusters[$i]['cluster_id']);*}
        </tr>
    {/foreach}
</ul>
</table>