{* customer_register.tpl *}
{load_presentation_object filename="customer_register" assign="obj"}

{*<ul id="breadcramps">
    <li><a href="">Αρχική</a></li>
    <li>> Γίνετε μέλος</li>
</ul>
<h1>Γίνετε μέλος</h1>
*}                            
<div id="customer_registration">

<section class="row">
    <article class="grid_9">
    <form method="post" action="{$obj->mLinkToCustomerRegister}" id="registration">
        <h3>Customer Information</h3>
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
                <label for="text">Password:</label>
        <input type="password" name="customer_password" id="customer_password" class="text" />
            {if $obj->mPasswordError}
                <label for="customer_password" class="error">Enter a password</label>
            {elseif $obj->mPasswordTooShort}
                <label for="customer_password" class="error">Password length >8 characters</label>
            {/if}
            </fieldset>
        
            <fieldset>
                <label for="text">Confirm Password:</label>
        <input type="password" name="customer_confirmed_password" id="customer_confirmed_password" class="text" />
            {if $obj->mPasswordConfirmError}
                <label for="customer_confirmed_password" class="error">Please confirm password</label>
            {elseif $obj->mPasswordMatchError}
                <label for="customer_confirmed_password" class="error">Wrong password confirmation</label>
            {/if}
            </fieldset>

            <fieldset>
                <label for="text">Street:</label>
                <input type="text" name="street_address" 
            id="street_address" class="text" value="{$obj->mCustomer.street_address}" />
            {if $obj->mStreetAddressError }<label for="street_address" class="error">Required question</label>{/if}
            </fieldset>
            
            <fieldset>
                <label for="text">City:</label>
                <input type="text" name="city" 
            id="city" class="text" value="{$obj->mCustomer.city}" />
            {if $obj->mCityError}<label for="city" class="error">Required question</label>{/if}
            </fieldset>
            
            <fieldset>
                <label for="text">Post Code:</label>
                <input type="text" name="customer_postcode" 
            id="customer_postcode" class="text" value="{$obj->mCustomer.postcode}" />
            {if $obj->mPostcodeError}<label for="postcode" class="error">Required question</label>{/if}
            </fieldset>
                
            <fieldset>
                <label for="text">Country:</label>
                <select name="customer_country_id">
                    {section name=i loop=$obj->mCountries}
                        <option value="{$obj->mCountries[i].country_id}" 
                            {if $obj->mCountries[i].country_id eq $obj->mCustomer.country_id}SELECTED{/if}>
                                {$obj->mCountries[i].name}</option>
                    {/section}
                </select>
            {if $obj->mCountryError}
                <li class="error">Required question</li>
            {/if}
            </fieldset>
        
            <fieldset>
                <label for="text">State:</label>
                <select name="customer_state_id">
                    <option value="" SELECTED>Select ...</option>
                    {section name=i loop=$obj->mStates}
                        <option value="{$obj->mStates[i].state_id}" 
                            {if $obj->mStates[i].state_id eq $obj->mCustomer.state_id}SELECTED{/if}>
                                {$obj->mStates[i].state_name}</option>
                    {/section}
                </select>
                {if $obj->mStateError}
                    <li class="error">Required question</li>
                {/if}
            </fieldset>
            
            <fieldset>
                <label for="text">Phone:</label>
                <input type="text" name="phone" 
            id="phone" class="text" value="{$obj->mCustomer.phone}" />
            {if $obj->mPhoneError}<label for="phone" class="error">Required question</label>{/if}
            </fieldset>
            
            <fieldset>
                <label for="text">Mobile:</label>
                <input type="text" name="mobile" 
            id="phone" class="text" value="{$obj->mCustomer.mobile}" />
            {if $obj->mMobileError}<label for="phone" class="error">Required question</label>{/if}
            </fieldset>
            
            <fieldset>
        <input class="btn" style="width:100px;" type="submit" name="submit_customer_register" value="Register" />
                <input class="white" type="reset" name="reset" id="submitbtn" tabindex="34" value="Reset" />
            </fieldset>
    </form>
    </article>
    </section>
    </div>

{*
    <div id="customer_account">
        <form id="registration_form" method="post" action="{$obj->mLinkToCustomerRegister}">
        <h2 class="heading">Πληροφορίες Χρήστη</h2>
        <ul class="forms">
        <li class="txt">Φύλο <span class="required">*</span>:</li>
        <li class="txt"><span><input name="customer_gender" type="radio" value="m" {if $obj->mCustomer.gender eq "m"}CHECKED{/if}/> άνδρας</span> <span><input name="customer_gender" type="radio" value="f" {if $obj->mCustomer.gender eq "f"}CHECKED{/if}/> γυναίκα</span></li>
        {if $obj->mGenderError}<li class="error">Επιλογή φύλου</li>{/if}
    </ul>
        <div class="clear"></div>
        <ul class="forms">
        <li class="txt">Όνομα <span class="required">*</span>:</li>
        <li class="inputfield"><input name="customer_first_name" type="text" class="bar" 
        value="{$obj->mCustomer.first_name}"/></li>
        {if $obj->mFirstNameError}<li class="error">Παρακαλω συμπληρώστε το όνομα σας.</li>{/if}
    </ul>
        <div class="clear"></div>
        <ul class="forms">
        <li class="txt">Επίθετο <span class="required">*</span>:</li>
        <li class="inputfield"><input name="customer_last_name" type="text" class="bar" 
        value="{$obj->mCustomer.last_name}"/></li>
        {if $obj->mLastNameError}
    <li class="error">Το επίθετο πρέπει να περιέχει τουλάχιστον {$obj->mLastNameMinLen} χαρακτήρες.</li>
    {/if}
    </ul>
        <div class="clear"></div>
        <ul class="forms">
        <li class="txt">Ψευδώνυμο:</li>
        <li class="inputfield"><input name="customer_nickname" type="text" class="bar" 
        value="{$obj->mCustomer.nickname}"/></li>
        </ul>
        <div class="clear"></div>
        <ul class="forms">
        <li class="txt">Διεύθυνση Email <span class="required">*</span>:</li>
        <li class="inputfield"><input name="customer_email" type="text" class="bar" 
        value="{$obj->mCustomer.email}"/></li>
        {if $obj->mEmailAlreadyTaken}
    <li class="error">Η διεύθυνση email χρησιμοποιείται ήδη.</li>
    {elseif $obj->mEmailError}
    <li class="error">Ξεχάσατε να εισάγετε διεύθυνση email.</li>
    {elseif $obj->mEmailInvalid}
    <li class="error">Παρακαλώ εισάγετε μια έγκυρη διεύθυνση email.</li>
    {/if}
    </ul>
        <div class="clear"></div>
        <ul class="forms">
        <li class="txt">Κωδικός <span class="required">*</span>:</li>
        <li class="inputfield"><input name="customer_password" type="password" class="bar" value=""/></li>
        {if $obj->mPasswordError}
    <li class="error">Ξεχάσατε να εισάγετε κωδικό.</li>
    {elseif $obj->mPasswordTooShort}
    <li class="error">Ο κωδικός πρέπει να έχει μήκος τουλάχιστον 8 χαρακτήρων.</li>
    {/if}
    </ul>
        <div class="clear"></div>
        <ul class="forms">
        <li class="txt">Επανάληψη κωδικού<span class="required">*</span>:</li>
        <li class="inputfield"><input name="customer_confirmed_password" type="password" class="bar" value=""/></li>
        {if $obj->mPasswordConfirmError}
    <li class="error">Παρακαλώ επανεισάγετε τον κωδικό.</li>
    {elseif $obj->mPasswordMatchError}
    <li class="error">Η επιβεβαίωση του κωδικού απέτυχε.</li>
    {/if}
    </ul>
        <div class="clear"></div>
        <h2 class="heading">Στοιχεία Αποστολής</h2>
        <ul class="forms">
        <li class="txt">Οδός <span class="required">*</span>:</li>
        <li class="inputfield"><input name="customer_street_address" type="text" 
        value="{$obj->mCustomer.street_address}" class="bar" /></li>
        {if $obj->mStreetAddressError}
    <li class="error">Η όδός πρέπει να περιέχει τουλάχιστον {$obj->mStreetAddressMinLen} χαρακτήρες.</li>
    {/if}
    </ul>    	
        <ul class="forms">
        <li class="txt">Πόλη/Περιοχή <span class="required">*</span>:</li>
        <li class="inputfield"><input name="customer_city" type="text" 
        value="{$obj->mCustomer.city}" class="bar" /></li>
        {if $obj->mCityError}
    <li class="error">Η πόλη πρέπει να περιέχει τουλάχιστον {$obj->mCityMinLen} χαρακτήρες.</li>
    {/if}
    </ul>    	
        <ul class="forms">
        <li class="txt">Νομός: <span class="required">*</span></li>
        <li class="inputfield">
        <select name="customer_state_id">
        <option value="" SELECTED>Επιλέξτε ...</option>
        {section name=i loop=$obj->mStates}
    <option value="{$obj->mStates[i].state_id}" 
    {if $obj->mStates[i].state_id eq $obj->mCustomer.state_id}SELECTED{/if}>
    {$obj->mStates[i].state_name}</option>
    {/section}
    </select>
    {if $obj->mStateError}
    <li class="error">Παρακαλώ επιλέξτε νομό.</li>
    {/if}
    </li>
        </ul>    	
        <ul class="forms">
        <li class="txt">Τ.Κ. <span class="required">*</span>:</li>
        <li class="inputfield"><input name="customer_postcode" type="text" 
        value="{$obj->mCustomer.postcode}" class="bar" /></li>
        {if $obj->mPostcodeError}
    <li class="error">Ο Τ.Κ πρέπει να περιέχει τουλάχιστον {$obj->mPostCodeMinLen} χαρακτήρες.</li>
    {/if}
    </ul>    	
        <ul class="forms">
        <li class="txt">Εταιρεία:</li>
        <li class="inputfield"><input name="customer_company" type="text" 
        value="{$obj->mCustomer.company}" class="bar" /></li>
        </ul>    	
        <ul class="forms">
        <li class="txt">Σταθερό Τηλέφωνο:</li>
        <li class="inputfield"><input name="customer_phone" type="text" 
        value="{$obj->mCustomer.phone}" class="bar" /></li>
        {if $obj->mPhoneError}
    <li class="error">Το σταθερό τηλέφωνο πρέπει να περιέχει τουλάχιστον {$obj->mPhoneMinLen} ψηφία.</li>
    {/if}
    </ul>    	
        <ul class="forms">
        <li class="txt">Κινητό Τηλέφωνο:</li>
        <li class="inputfield"><input name="customer_mobile" type="text" 
        value="{$obj->mCustomer.mobile}" class="bar" /></li>
        {if $obj->mMobileError}
    <li class="error">Το κινητό τηλέφωνο πρέπει να περιέχει τουλάχιστον {$obj->mMobileMinLen} ψηφία.</li>
    {/if}
    </ul>    	
        <ul class="forms">
        <li class="txt">Χώρα: <span class="required">*</span></li>
        <li class="inputfield">
        <select name="customer_country_id">
        {section name=i loop=$obj->mCountries}
    <option value="{$obj->mCountries[i].country_id}" 
    {if $obj->mCountries[i].country_id eq $obj->mCustomer.country_id}SELECTED{/if}>
    {$obj->mCountries[i].name}</option>
    {/section}
    </select>
    {if $obj->mCountryError}
    <li class="error">Παρακαλώ επιλέξτε χώρα.</li>
    {/if}
    </li>
        </ul>    	
        <div class="clear"></div>
        <h2 class="heading">Στοιχεία Τιμολόγησης</h2>
        <ul class="forms">
        <li class="txt">Επωνυμία:</li>
        <li class="inputfield"><input name="customer_company_name" type="text" 
        value="{$obj->mCustomer.company_name}" class="bar" /></li>
        {if $obj->mCompanyNameError}
    <li class="error">Παρακαλώ εισάγετε την επωνυμία της εταιρείας σας.</li>
    {/if}
    </ul>    	
        <ul class="forms">
        <li class="txt">Διεύθυνση εταιρείας:</li>
        <li class="inputfield"><input name="customer_company_address" type="text" 
        value="{$obj->mCustomer.company_address}" class="bar" /></li>
        {if $obj->mCompanyAddressError}
    <li class="error">Η διεύθυνση της εταιρείας πρέπει να περιέχει τουλάχιστον {$obj->mStreetAddressMinLen} χαρακτήρες.</li>
    {/if}
    </ul>    	
        <ul class="forms">
        <li class="txt">Επάγγελμα:</li>
        <li class="inputfield"><input name="company_profession" type="text" 
        value="{$obj->mCustomer.company_profession}" class="bar" /></li>
        {if $obj->mCompanyProfessionError}
    <li class="error">Παρακαλώ εισάγετε το επάγγελμά σας.</li>
    {/if}
    </ul>    	
        <ul class="forms">
        <li class="txt">ΑΦΜ:</li>
        <li class="inputfield"><input name="customer_vat_registration" type="text" 
        value="{$obj->mCustomer.vat_registration}" class="bar" /></li>
        {if $obj->mVATRegistrationError}
    <li class="error">Παρακαλώ εισάγετε έναν έγκυρο αριθμό για το ΑΦΜ.</li>
    {/if}
    </ul>    	
        <ul class="forms">
        <li class="txt">ΔΟΥ:</li>
        <li class="inputfield"><input name="customer_tax_office" type="text" 
        value="{$obj->mCustomer.tax_office}" class="bar" /></li>
        {if $obj->mTaxOfficeError}
    <li class="error">Εισάγετε τη ΔΟΥ στην οποία υπάγεται η εταιρεία.</li>
    {/if}
    </ul>
        <div class="clear"></div>

        <input class="redBtn" type="submit" name="submit_customer_register" value="Εγγραφή" />
        </form>
        </div>
        *}
