<?php /* Smarty version 2.6.22, created on 2015-08-30 12:03:11
         compiled from customer_account.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'customer_account.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'customer_account','assign' => 'obj'), $this);?>



<div id="customer_account">
<section class="row">
    <article class="grid_9">
    <form id="registration" method="post" action="<?php echo $this->_tpl_vars['obj']->mLinkToAccountUpdate; ?>
">
        <h3>Customer Account</h3>
        
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
                <label for="text">Update Password:</label>
                <input type="checkbox" name="pass_change" id="pass_change" <?php if ($this->_tpl_vars['obj']->mPasswordChange): ?>CHECKED<?php endif; ?> />
            </fieldset>
            
            <div id="change_pass">
            <fieldset>
                <label for="text">Current Password:</label>
                <input type="password" name="customer_old_password" id="customer_old_password" class="text" />
                <?php if ($this->_tpl_vars['obj']->mOldPasswordError): ?>
                    <label for="customer_old_password" class="error">Enter your current password</label>
                <?php endif; ?>
            </fieldset>

            <fieldset>
                <label for="text">New Password:</label>
                <input type="password" name="customer_password" id="customer_password" class="text" />
                <?php if ($this->_tpl_vars['obj']->mPasswordError): ?>
                    <label for="customer_password" class="error">Enter a password</label>
                <?php elseif ($this->_tpl_vars['obj']->mPasswordTooShort): ?>
                    <label for="customer_password" class="error">Password length >8 characters</label>
                <?php endif; ?>
            </fieldset>

            <fieldset>
                <label for="text">Confirm New Password:</label>
                <input type="password" name="customer_confirmed_password" id="customer_confirmed_password" class="text" />
                <?php if ($this->_tpl_vars['obj']->mPasswordConfirmError): ?>
                    <label for="customer_confirmed_password" class="error">Confirm password</label>
                <?php elseif ($this->_tpl_vars['obj']->mPasswordMatchError): ?>
                    <label for="customer_confirmed_password" class="error">Password confirmation error</label>
                <?php endif; ?>
            </fieldset>
        </div>
                        <input class="btn" style="width:100px;" type="submit" name="submit_customer_update" value="Update" />
    </form>
    </article>
    </section>
</div>