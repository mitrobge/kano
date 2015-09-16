<?php /* Smarty version 2.6.22, created on 2015-08-30 12:12:16
         compiled from customer_info.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'customer_info.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'customer_info','assign' => 'obj'), $this);?>


<?php if ($this->_tpl_vars['obj']->mCustomerIsLoggedIn): ?>
   <li><a href="<?php echo $this->_tpl_vars['obj']->mLinkToLogout; ?>
">Logout</a></li>
   <li class="registration"><a id="to_customer_account" href="<?php echo $this->_tpl_vars['obj']->mLinkToAccount; ?>
">User Profile</a></li>
<?php else: ?>
    <li><a class="login_btn" id="login_btn" href="#login">Sign-in</a></li>
    <li class="registration"><a href="<?php echo $this->_tpl_vars['obj']->mLinkToAccount; ?>
">Register</a></li>
<?php endif; ?>