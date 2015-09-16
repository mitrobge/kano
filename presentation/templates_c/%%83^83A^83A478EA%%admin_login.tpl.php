<?php /* Smarty version 2.6.22, created on 2015-09-14 20:38:46
         compiled from admin_login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'admin_login.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'admin_login','assign' => 'obj'), $this);?>

 <div id="box">
    <h3 id="adduser">Σύνδεση</h3>
<?php if ($this->_tpl_vars['obj']->mLoginMessage != ""): ?>
    <p style="color:red"><?php echo $this->_tpl_vars['obj']->mLoginMessage; ?>
</p>
<?php endif; ?>
    <form id="form" action="<?php echo $this->_tpl_vars['obj']->mLinkToAdmin; ?>
" method="post">
    <fieldset id="personal">
        <label for="email">Διεύθυνση Email : </label>
        <input name="email" id="email" type="text" value="<?php echo $this->_tpl_vars['obj']->mEmail; ?>
" tabindex="2" />
        <br />
        <label for="pass">Κωδικός : </label>
        <input name="password" id="pass" type="password" tabindex="2" />
        <br />
    </fieldset>
        <input id="button1" type="submit" name="submit" value="Σύνδεση" /> 
    </form>
</div>