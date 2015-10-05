{* admin_category_attributes.tpl *}
{load_presentation_object filename="admin_survey_questions" assign="obj"}

<form id="form" method="post" action="{$obj->mLinkToSurveyQuestionsAdmin}">
    <h3>
       Ερωτήσεις έρευνας "{$obj->mCategory.name}"
            &nbsp;(<a href="">Πίσω στις κατηγορίες</a>)
    </h3>
    <br>
    {if $obj->mWarningMessage}
        <p style="color:orange"><font size="2">{$obj->mWarningMessage}</font></p>
        <br />
    {/if}
    {if $obj->mErrorMessage}
        <p style="color:red"><font size="2">{$obj->mErrorMessage}</font></p>
        <br />
    {/if}
    
    <fieldset id="admin_add_question">
    <legend>Προσθήκη Ερώτησης</legend>
    {section name=q loop=2} 
    {section name=i loop=$obj->mLanguages}
        <label>{if $smarty.section.i.first}Ερώτηση{if $smarty.section.q.first} (+){else}(-){/if}: {/if}</label>
        <input type="text" name="added_attribute_name_{$smarty.section.q.index}_{$obj->mLanguages[i].language_id}" value="" size="30" />
        {if count($obj->mLanguages) > 1} 
            <img src="images/{$obj->mLanguages[i].language_flag}" alt="{$obj->mLanguages[i].language_name}" width="15" height="15" border="0" />
        {/if}
        <br>
    {/section}
    {/section}
    <input id="button1" type="submit" name="submit_add_attr_0" value="Προσθήκη" />
    <br />
    </fieldset>
    {if count($obj->mSurvey.questions) eq 0}
        <p><b>Δεν υπάρχουν ερωτήσεις!</b></p>
    {else}
        <fieldset id="admin_category_attributes">
        <legend>Ερωτήσεις</legend>
        <table>
            <thead>
                <th width="150">Όνομα χαρακτηριστικού</th>
                <th width="150">Ερώτηση</th>
                <th width="100">Ενέργειες</th>
            </thead>
            <tbody>
            {section name=i loop=$obj->mSurvey.questions}
                {if $obj->mEditItem == $obj->mSurvey.questions[i].qid}
                sdf
                              {$obj->GetQuestionName($obj->mSurvey.questions[0].question, $obj->mLanguages[1].language_id)}
                              sdf
                    <tr>
                        <td>
                            <table>
                                {section name=j loop=$obj->mLanguages}
                                    <tr>
                                    <input type="text" name="attribute_attribute_{$obj->mLanguages[j].language_id}" 
                                        value="{$obj->GetQuestionName($obj->mSurvey.questions[i].attribute, 
                                            $obj->mLanguages[j].language_id)}" size="20" />
                                    {if count($obj->mLanguages) > 1} 
                                        <img src="images/{$obj->mLanguages[j].language_flag}" alt="{$obj->mLanguages[j].language_name}" width="15" height="15" border="0" />
                                    {/if}
                                    </tr>
                                {/section}
                            </table>
                        </td>
                        <td>
                            <table>
                                {section name=j loop=$obj->mLanguages}
                                    <tr>
                                    <input type="text" name="attribute_name_{$obj->mLanguages[j].language_id}" 
                                        value="{$obj->GetQuestionName($obj->mSurvey.questions[i].question, 
                                            $obj->mLanguages[j].language_id)}" size="20" />
                                    {if count($obj->mLanguages) > 1} 
                                        <img src="images/{$obj->mLanguages[j].language_flag}" alt="{$obj->mLanguages[j].language_name}" width="15" height="15" border="0" />
                                    {/if}
                                    </tr>
                                {/section}
                            </table>
                        </td>
                        <td>
                        <input id="button1" type="submit" name="submit_update_attr_{$obj->mSurvey.questions[i].qid}"
                            value="Ενημέρωση" />
                        <input id="button1" type="reset" name="reset"
                            value="Επαναφορά" />
                        <input id="button1" type="submit" name="cancel"
                            value="Άκυρο" />
                        </td>
                    </tr>
                {else}
                    <tr>
                        <td>{$obj->mSurvey.questions[i].attribute}</td>
                        <td>{$obj->mSurvey.questions[i].question}</td>
                        <td>
                        <input id="button1" type="submit" name="submit_edit_attr_{$obj->mSurvey.questions[i].qid}" 
                            value="Τροποποίηση" /></br>
                        <input id="button1" type="submit" name="submit_delete_attr_{$obj->mSurvey.questions[i].qid}"
                            value="Διαγραφή" />
                        </td>
                    </tr>
                {/if}
            {/section}
            </tbody>
        </table>
        </fieldset>
    {/if}
</form>
