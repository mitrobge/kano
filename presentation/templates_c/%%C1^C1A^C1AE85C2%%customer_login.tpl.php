<?php /* Smarty version 2.6.22, created on 2015-08-02 16:51:14
         compiled from customer_login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'customer_login.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'customer_login','assign' => 'obj'), $this);?>

<?php if ($this->_tpl_vars['obj']->mErrorMessage): ?>
    <?php echo '
    <script type="text/javascript">
    $(document).ready(function() {
        $("#login_btn").trigger(\'click\');
    });
    </script>
    '; ?>

<?php endif; ?>
<div id="login">
    <form id="login_form" method="post" action="<?php echo $this->_tpl_vars['obj']->mLinkToLogin; ?>
">
        <?php if ($this->_tpl_vars['obj']->mErrorMessage): ?>
            <label class="error"><?php echo $this->_tpl_vars['obj']->mErrorMessage; ?>
</label>
        <?php endif; ?>

        <fieldset>
        <label for="text">Username:</label>
        <input type="text" class="text" name="email" value="<?php echo $this->_tpl_vars['obj']->mEmail; ?>
" />
        </fieldset>
        <fieldset>
        <label for="text">Password:</label>
        <input type="password" class="text" name="password" />
        </fieldset>
        <a href="<?php echo $this->_tpl_vars['obj']->mLinkToRecoverPassword; ?>
">Ξεχάσατε τον κωδικό σας;</a>
                <input class="btn" style="width:90px" type="submit" name="Login" value="login" />
    </form>	
</div>