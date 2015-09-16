<?php /* Smarty version 2.6.22, created on 2015-08-02 18:43:39
         compiled from customer_register.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'customer_register.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'customer_register','assign' => 'obj'), $this);?>


                            
<div id="customer_registration">

<section class="row">
    <article class="grid_9">
    <form method="post" action="<?php echo $this->_tpl_vars['obj']->mLinkToCustomerRegister; ?>
" id="registration">
        <h3>Customer Information</h3>
            <fieldset>
                <label for="text">Gender:</label>
                <select name="customer_gender" id="customer_gender" class="text">
                <option value="">Select...</option>
                <option value="m" <?php if ($this->_tpl_vars['obj']->mCustomer['gender'] == 'm'): ?>SELECTED<?php endif; ?>>Male</option>
                <option value="f" <?php if ($this->_tpl_vars['obj']->mCustomer['gender'] == 'f'): ?>SELECTED<?php endif; ?>>Female</option>
            </select>
            <?php if ($this->_tpl_vars['obj']->mGenderError): ?><label for="customer_gender" class="error">Required question</label><?php endif; ?>
            </fieldset>
            
            <fieldset>
                <label for="text">First Name:</label>
                <input type="text" name="customer_first_name" 
            id="customer_first_name" class="text" value="<?php echo $this->_tpl_vars['obj']->mCustomer['first_name']; ?>
" />
            <?php if ($this->_tpl_vars['obj']->mFirstNameError): ?><label for="customer_first_name" class="error">equired question</label><?php endif; ?>
            </fieldset>
        
            <fieldset>
                <label for="text">Last Name:</label>
                <input type="text" name="customer_last_name" 
            id="customer_last_name" class="text" value="<?php echo $this->_tpl_vars['obj']->mCustomer['last_name']; ?>
" />
            <?php if ($this->_tpl_vars['obj']->mLastNameError): ?><label for="customer_last_name" class="error">Required question</label><?php endif; ?>
            </fieldset>
        
            <fieldset>
                <label for="text">Email:</label>
        <input type="text" name="customer_email" 
            id="customer_email" class="text" value="<?php echo $this->_tpl_vars['obj']->mCustomer['email']; ?>
" />
            <?php if ($this->_tpl_vars['obj']->mEmailAlreadyTaken): ?>
                <label for="customer_email" class="error">The email address is in use</label>
            <?php elseif ($this->_tpl_vars['obj']->mEmailError): ?>
                <label for="customer_email" class="error">Enter an email address</label>
            <?php elseif ($this->_tpl_vars['obj']->mEmailInvalid): ?>
                <label for="customer_email" class="error">Please enter a valid email</label>
            <?php endif; ?>
            </fieldset>
        
            <fieldset>
                <label for="text">Password:</label>
        <input type="password" name="customer_password" id="customer_password" class="text" />
            <?php if ($this->_tpl_vars['obj']->mPasswordError): ?>
                <label for="customer_password" class="error">Enter a password</label>
            <?php elseif ($this->_tpl_vars['obj']->mPasswordTooShort): ?>
                <label for="customer_password" class="error">Password length >8 characters</label>
            <?php endif; ?>
            </fieldset>
        
            <fieldset>
                <label for="text">Confirm Password:</label>
        <input type="password" name="customer_confirmed_password" id="customer_confirmed_password" class="text" />
            <?php if ($this->_tpl_vars['obj']->mPasswordConfirmError): ?>
                <label for="customer_confirmed_password" class="error">Please confirm password</label>
            <?php elseif ($this->_tpl_vars['obj']->mPasswordMatchError): ?>
                <label for="customer_confirmed_password" class="error">Wrong password confirmation</label>
            <?php endif; ?>
            </fieldset>

            <fieldset>
                <label for="text">Street:</label>
                <input type="text" name="street_address" 
            id="street_address" class="text" value="<?php echo $this->_tpl_vars['obj']->mCustomer['street_address']; ?>
" />
            <?php if ($this->_tpl_vars['obj']->mStreetAddressError): ?><label for="street_address" class="error">Required question</label><?php endif; ?>
            </fieldset>
            
            <fieldset>
                <label for="text">City:</label>
                <input type="text" name="city" 
            id="city" class="text" value="<?php echo $this->_tpl_vars['obj']->mCustomer['city']; ?>
" />
            <?php if ($this->_tpl_vars['obj']->mCityError): ?><label for="city" class="error">Required question</label><?php endif; ?>
            </fieldset>
            
            <fieldset>
                <label for="text">Post Code:</label>
                <input type="text" name="customer_postcode" 
            id="customer_postcode" class="text" value="<?php echo $this->_tpl_vars['obj']->mCustomer['postcode']; ?>
" />
            <?php if ($this->_tpl_vars['obj']->mPostcodeError): ?><label for="postcode" class="error">Required question</label><?php endif; ?>
            </fieldset>
                
            <fieldset>
                <label for="text">Country:</label>
                <select name="customer_country_id">
                    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mCountries) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                        <option value="<?php echo $this->_tpl_vars['obj']->mCountries[$this->_sections['i']['index']]['country_id']; ?>
" 
                            <?php if ($this->_tpl_vars['obj']->mCountries[$this->_sections['i']['index']]['country_id'] == $this->_tpl_vars['obj']->mCustomer['country_id']): ?>SELECTED<?php endif; ?>>
                                <?php echo $this->_tpl_vars['obj']->mCountries[$this->_sections['i']['index']]['name']; ?>
</option>
                    <?php endfor; endif; ?>
                </select>
            <?php if ($this->_tpl_vars['obj']->mCountryError): ?>
                <li class="error">Required question</li>
            <?php endif; ?>
            </fieldset>
        
            <fieldset>
                <label for="text">State:</label>
                <select name="customer_state_id">
                    <option value="" SELECTED>Select ...</option>
                    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mStates) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                        <option value="<?php echo $this->_tpl_vars['obj']->mStates[$this->_sections['i']['index']]['state_id']; ?>
" 
                            <?php if ($this->_tpl_vars['obj']->mStates[$this->_sections['i']['index']]['state_id'] == $this->_tpl_vars['obj']->mCustomer['state_id']): ?>SELECTED<?php endif; ?>>
                                <?php echo $this->_tpl_vars['obj']->mStates[$this->_sections['i']['index']]['state_name']; ?>
</option>
                    <?php endfor; endif; ?>
                </select>
                <?php if ($this->_tpl_vars['obj']->mStateError): ?>
                    <li class="error">Required question</li>
                <?php endif; ?>
            </fieldset>
            
            <fieldset>
                <label for="text">Phone:</label>
                <input type="text" name="phone" 
            id="phone" class="text" value="<?php echo $this->_tpl_vars['obj']->mCustomer['phone']; ?>
" />
            <?php if ($this->_tpl_vars['obj']->mPhoneError): ?><label for="phone" class="error">Required question</label><?php endif; ?>
            </fieldset>
            
            <fieldset>
                <label for="text">Mobile:</label>
                <input type="text" name="mobile" 
            id="phone" class="text" value="<?php echo $this->_tpl_vars['obj']->mCustomer['mobile']; ?>
" />
            <?php if ($this->_tpl_vars['obj']->mMobileError): ?><label for="phone" class="error">Required question</label><?php endif; ?>
            </fieldset>
            
            <fieldset>
        <input class="btn" style="width:100px;" type="submit" name="submit_customer_register" value="Register" />
                <input class="white" type="reset" name="reset" id="submitbtn" tabindex="34" value="Reset" />
            </fieldset>
    </form>
    </article>
    </section>
    </div>
