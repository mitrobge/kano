{* customer_account.tpl *}
{load_presentation_object filename="customer_account" assign="obj"}

{*<ul id="breadcramps">
    <li><a href="">Αρχική</a></li>
    <li>> <a href="">O Λογαριασμός μου</a></li>
    <li>> Customer Information</li>
</ul>
<h1>Profile</h1>
*}

<div id="customer_account">
<section class="row">
    <article class="grid_9">
    <form id="registration" method="post" action="{$obj->mLinkToAccountUpdate}">
        <h3>Customer Account</h3>
        
            <fieldset>
                <label for="text">Gender:</label>
                <select name="customer_gender" id="customer_gender" class="text">
                <option value="">Select...</option>
                <option value="m" {if $obj->mCustomer.gender eq "m"}SELECTED{/if}>Male</option>
                <option value="f" {if $obj->mCustomer.gender eq "f"}SELECTED{/if}>Female</option>
            </select>
            {if $obj->mGenderError}<label for="customer_gender" class="error">Required question</label>{/if}
            </fieldset>
            
            <fieldset>
                <label for="text">First Name:</label>
                <input type="text" name="customer_first_name" 
            id="customer_first_name" class="text" value="{$obj->mCustomer.first_name}" />
            {if $obj->mFirstNameError}<label for="customer_first_name" class="error">equired question</label>{/if}
            </fieldset>
        
            <fieldset>
                <label for="text">Last Name:</label>
                <input type="text" name="customer_last_name" 
            id="customer_last_name" class="text" value="{$obj->mCustomer.last_name}" />
            {if $obj->mLastNameError}<label for="customer_last_name" class="error">Required question</label>{/if}
            </fieldset>
        
            <fieldset>
                <label for="text">Email:</label>
            <input type="text" name="customer_email" 
            id="customer_email" class="text" value="{$obj->mCustomer.email}" />
            {if $obj->mEmailAlreadyTaken}
                <label for="customer_email" class="error">The email address is in use</label>
            {elseif $obj->mEmailError}
                <label for="customer_email" class="error">Enter an email address</label>
            {elseif $obj->mEmailInvalid}
                <label for="customer_email" class="error">Please enter a valid email</label>
            {/if}
            </fieldset>

            <fieldset>
                <label for="text">Update Password:</label>
                <input type="checkbox" name="pass_change" id="pass_change" {if $obj->mPasswordChange}CHECKED{/if} />
            </fieldset>
            
            <div id="change_pass">
            <fieldset>
                <label for="text">Current Password:</label>
                <input type="password" name="customer_old_password" id="customer_old_password" class="text" />
                {if $obj->mOldPasswordError}
                    <label for="customer_old_password" class="error">Enter your current password</label>
                {/if}
            </fieldset>

            <fieldset>
                <label for="text">New Password:</label>
                <input type="password" name="customer_password" id="customer_password" class="text" />
                {if $obj->mPasswordError}
                    <label for="customer_password" class="error">Enter a password</label>
                {elseif $obj->mPasswordTooShort}
                    <label for="customer_password" class="error">Password length >8 characters</label>
                {/if}
            </fieldset>

            <fieldset>
                <label for="text">Confirm New Password:</label>
                <input type="password" name="customer_confirmed_password" id="customer_confirmed_password" class="text" />
                {if $obj->mPasswordConfirmError}
                    <label for="customer_confirmed_password" class="error">Confirm password</label>
                {elseif $obj->mPasswordMatchError}
                    <label for="customer_confirmed_password" class="error">Password confirmation error</label>
                {/if}
            </fieldset>
        </div>
{*                            
        <div id="address">
            <h3>Address Book</h3>
            <a class="plus"></a>
            <a class="delete"></a>
            <div class="address">
                <h4>Address 1</h4>
                <label for="customer_street_address">Διεύθυνση<input type="text" name="customer_street_address" 
                    id="customer_street_address" class="text" value="{$obj->mCustomer.street_address}" />
                    {if $obj->mStreetAddressError}
                        <label for="customer_street_address" class="error">Η οδός πρέπει να περιέχει τουλάχιστον {$smarty.const.CUSTOMER_STREET_ADDR_MINLEN} χαρακτήρες.</label>
                    {/if}
                </label>
                <label class="middle last" for="customer_city">Πόλη/Περιοχή<input type="text" name="customer_city" 
                    id="customer_city" class="text" value="{$obj->mCustomer.city}" />
                    {if $obj->mCityError}
                        <label for="customer_city" class="error">Η πόλη πρέπει να περιέχει τουλάχιστον {$smarty.const.CUSTOMER_CITY_MINLEN} χαρακτήρες.</label>
                    {/if}
                </label>
                <label class="middle" for="customer_state_id">Νομός
                    <select name="customer_state_id" id="customer_state_id" class="text">
                        <option value="" SELECTED>Επιλέξτε ...</option>
                        {section name=i loop=$obj->mStates}
                            <option value="{$obj->mStates[i].state_id}" 
                                {if $obj->mStates[i].state_id eq $obj->mCustomer.state_id}SELECTED{/if}>
                                    {$obj->mStates[i].state_name}</option>
                        {/section}
                    </select>
                    {if $obj->mStateError}
                        <label for="customer_state_id" class="error">Παρακαλώ επιλέξτε νομό.</label>
                    {/if}
                </label>
                <label class="small" for="customer_postcode">ΤΚ<input type="text" name="customer_postcode" 
                    id="customer_postcode" class="text" value="{$obj->mCustomer.postcode}" />
                    {if $obj->mPostcodeError}
                        <label for="customer_postcode" class="error">Ο Τ.Κ πρέπει να περιέχει τουλάχιστον {$smarty.const.CUSTOMER_POSTCODE_MINLEN} χαρακτήρες.</label>
                    {/if}
                </label>
                <div class="clear"></div>
                <label class="middle" for="customer_phone">Τηλέφωνο<input type="text" name="customer_phone" 
                    id="customer_phone" class="text" value="{$obj->mCustomer.phone}" />
                    {if $obj->mPhoneError}
                        <label for="customer_phone" class="error">Το Σταθερό Τηλέφωνο πρέπει να περιέχει τουλάχιστον {$smarty.const.CUSTOMER_PHONE_MINLEN} ψηφία.</label>
                    {/if}
                </label>
                <label class="middle" for="customer_mobile">Κινητό<input type="text" name="customer_mobile" 
                    id="customer_mobile" class="text" value="{$obj->mCustomer.mobile}" />
                    {if $obj->mMobileError}
                        <label for="customer_mobile" class="error">Το Κινητό Τηλέφωνο πρέπει να περιέχει τουλάχιστον {$smarty.const.CUSTOMER_MOBILE_MINLEN} ψηφία.</label>
                    {/if}
                </label>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        
        <h3>Στοιχεία Τιμολόγησης <span style="font-size:70%;">(προαιρετικά)</span></h3>
        <label for="customer_company_name">Eπωνυμία<input type="text" name="customer_company_name" 
            id="customer_company_name" class="text" value="{$obj->mCustomer.company_name}" />
            {if $obj->mCompanyNameError}
                <label for="customer_company_name" class="error">Παρακαλώ εισάγετε το όνομα της εταιρεία σας.</label>
            {/if}
        </label>
        <label class="middle last" for="company_profession">Επάγγελμα<input type="text" name="company_profession" 
            id="company_profession" class="text" value="{$obj->mCustomer.company_profession}" />
            {if $obj->mCompanyProfessionError}
                <label for="company_profession" class="error">Παρακαλώ εισάγετε το επάγγελμά σας.</label>
            {/if}
        </label>
        <label for="customer_company_address">Διεύθυνση<input type="text" name="customer_company_address" 
            id="customer_company_address" class="text" value="{$obj->mCustomer.company_address}" />
            {if $obj->mCompanyAddressError}
                <label for="customer_company_address" class="error">Η οδός πρέπει να περιέχει τουλάχιστον {$smarty.const.CUSTOMER_STREET_ADDR_MINLEN} χαρακτήρες.</label>
            {/if}
        </label>
        <label class="middle last" for="customer_company_city">Πόλη/Περιοχή<input type="text" name="customer_company_city" 
            id="customer_company_city" class="text" value="{$obj->mCustomer.company_city}" />
            {if $obj->mCompanyCityError}
                <label for="customer_company_city" class="error">Η πόλη πρέπει να περιέχει τουλάχιστον {$smarty.const.CUSTOMER_CITY_MINLEN} χαρακτήρες.</label>
            {/if}
        </label>
        <label class="middle" for="customer_company_state_id">Νομός
            <select name="customer_company_state_id" id="customer_company_state_id" class="text">
                <option value="" SELECTED>Επιλέξτε ...</option>
                {section name=i loop=$obj->mStates}
                    <option value="{$obj->mStates[i].state_id}" 
                        {if $obj->mStates[i].state_id eq $obj->mCustomer.company_state_id}SELECTED{/if}>
                            {$obj->mStates[i].state_name}</option>
                {/section}
            </select>
            {if $obj->mCompanyStateError}
                <label for="customer_company_state_id" class="error">Παρακαλώ επιλέξτε νομό.</label>
            {/if}
        </label>
        <input type="hidden" name="customer_country_id" id="customer_country_id" value="84" />
        <label class="small" for="customer_company_postcode">ΤΚ<input type="text" name="customer_company_postcode" 
            id="customer_company_postcode" class="text" value="{$obj->mCustomer.company_postcode}" />
            {if $obj->mCompanyPostcodeError}
                <label for="customer_company_postcode" class="error">Ο Τ.Κ πρέπει να περιέχει τουλάχιστον {$smarty.const.CUSTOMER_POSTCODE_MINLEN} χαρακτήρες.</label>
            {/if}
        </label>
        <div class="clear"></div>
        <label class="small" for="company_vat_registration">ΑΦΜ<input type="text" name="company_vat_registration" 
            id="company_vat_registration" class="text" value="{$obj->mCustomer.company_vat_registration}" />
            {if $obj->mCompanyVATRegistrationError}
                <label for="company_vat_registration" class="error">Παρακαλώ εισάγετε έναν έγκυρο αριθμό ΑΦΜ.</label>
            {/if}
        </label>
        <label class="middle last" for="company_tax_office">ΔΟΥ<input type="text" name="company_tax_office" 
            id="company_tax_office" class="text" value="{$obj->mCustomer.company_tax_office}" />
            {if $obj->mCompanyTaxOfficeError}
                <label for="company_tax_office" class="error">Παρακαλώ εισάγετε τη ΔΟΥ στην οποία υπάγεται η εταιρεία σας.</label>
            {/if}
        </label>
        <div class="clear"></div>
*}
        {*<label for="tel2">Τηλέφωνο 2<input type="text" name="tel2" id="tel2" class="text" /></label>
        <div class="clear"></div>*}
        {*<a class="btn">ενημέρωση</a>*}
        <input class="btn" style="width:100px;" type="submit" name="submit_customer_update" value="Update" />
    </form>
    </article>
    </section>
</div>
