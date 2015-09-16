<?php /* Smarty version 2.6.22, created on 2015-09-14 20:52:42
         compiled from admin_administrator_details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'admin_administrator_details.tpl', 2, false),array('function', 'html_options', 'admin_administrator_details.tpl', 60, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'admin_administrator_details','assign' => 'obj'), $this);?>


<?php if (! isset ( $_GET['ChangePassword'] )): ?>
    <h3>
    <a href="<?php echo $this->_tpl_vars['obj']->mLinkToAdministrators; ?>
">Όλοι οι διαχειριστές</a>
    </h3>
    <br>
    <br>
    <a href="<?php echo $this->_tpl_vars['obj']->mLinkToChangePassword; ?>
">Αλλαγή κωδικού</a>
    <br>
    <br>
<?php else: ?>
    <h3>
    <a href="<?php echo $this->_tpl_vars['obj']->mLinkToAdministratorDetails; ?>
">Λεπτομέρειες διαχειριστή</a>
    </h3>
<?php endif; ?>

<?php if ($this->_tpl_vars['obj']->mErrorMessage): ?>
<p style="color:red">ERROR: <?php echo $this->_tpl_vars['obj']->mErrorMessage; ?>
</p>
<?php endif; ?>

<form id="form" method="post" action="">
    <?php if (isset ( $_GET['ChangePassword'] )): ?>
        <fieldset id="admin_change_pass">
        <legend>Αλλαγή κωδικού</legend>
        <?php if ($this->_tpl_vars['obj']->mAdministrator['administrator_id'] == $this->_tpl_vars['obj']->mMyAdministratorId): ?>
            <label>Τρέχον κωδικός : </label> 
                <input type="password" name="admin_existing_password" value="">
            <br />
        <?php endif; ?>
        <label>Νέος κωδικός : </label> 
            <input type="password" name="admin_new_password" value="">
        <br />
        <label>Επιβεβαίωση νέου κωδικού: </label>
            <input type="password" name="admin_confirm_new_password" value="">
        <br />
        </fieldset>
    <?php else: ?>
        <fieldset id="admin_info">
        <legend>Πληροφορίες Διαχειριστή</legend>
        <label>Δημηιουργήθηκε: </label>
            <?php echo $this->_tpl_vars['obj']->mAdministrator['created_on']; ?>

        <br />
        <label>Τελ. σύνδεση: </label>
            <?php echo $this->_tpl_vars['obj']->mAdministrator['last_login']; ?>

        <br />
        <label>Όνομα: </label> 
            <input type="text" name="admin_first_name" value="<?php echo $this->_tpl_vars['obj']->mAdministrator['first_name']; ?>
">
        <br />
        <label>Επίθετο: </label> 
            <input type="text" name="admin_last_name" value="<?php echo $this->_tpl_vars['obj']->mAdministrator['last_name']; ?>
">
        <br />
        <label>Διεύθυνση Email: </label>
            <input type="text" name="admin_email" value="<?php echo $this->_tpl_vars['obj']->mAdministrator['email']; ?>
">
        <br />
        <?php if ($this->_tpl_vars['obj']->mHasPermission): ?> 
            <label>Κατάσταση: </label>
                <select name="admin_status">
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['obj']->mAdministratorStatusOptions,'selected' => $this->_tpl_vars['obj']->mAdministrator['status']), $this);?>

                </select>
            <br />
            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mAvailablePermissions) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                <?php if ($this->_sections['i']['first'] || $this->_tpl_vars['obj']->mAvailablePermissions[$this->_sections['i']['index']]['name'] !== $this->_tpl_vars['obj']->mAvailablePermissions[$this->_sections['i']['index_prev']]['name']): ?>
                    <?php if (! $this->_sections['i']['first']): ?>
                        <br>
                    <?php endif; ?>
                    <br>
                    <label style="width:220px"><?php echo $this->_tpl_vars['obj']->mAvailablePermissions[$this->_sections['i']['index']]['name']; ?>
 : </label>
                <?php endif; ?>
                <?php $this->assign('permission_id', $this->_tpl_vars['obj']->mAvailablePermissions[$this->_sections['i']['index']]['permission_id']); ?>
                <input type="checkbox" name="permission[]" 
                    value="<?php echo $this->_tpl_vars['obj']->mAvailablePermissions[$this->_sections['i']['index']]['permission_id']; ?>
" 
                        <?php if (isset ( $this->_tpl_vars['obj']->mAdministrator['permissions_ids_flipped'][$this->_tpl_vars['permission_id']] )): ?>checked="yes"<?php endif; ?>/>&nbsp 
            <?php endfor; endif; ?>
            <br />
        <?php else: ?>
            <input type="hidden" name="admin_status" value="<?php echo $this->_tpl_vars['obj']->mAdministrator['status']; ?>
">
            <input type="hidden" name="permission[]" value="<?php echo $this->_tpl_vars['obj']->mAdministrator['permissions_ids']; ?>
">
        <?php endif; ?>
        </fieldset>
    <?php endif; ?>
    
    <?php if (isset ( $_GET['ChangePassword'] )): ?>
        <input type="hidden" name="admin_email" value="<?php echo $this->_tpl_vars['obj']->mAdministrator['email']; ?>
">
    <?php else: ?>
        <input type="hidden" name="admin_created_on" value="<?php echo $this->_tpl_vars['obj']->mAdministrator['created_on']; ?>
">
        <input type="hidden" name="admin_last_login" value="<?php echo $this->_tpl_vars['obj']->mAdministrator['last_login']; ?>
">
    <?php endif; ?>
    
    <input id="button1" type="submit" name="submit_save_changes" value="Αποθήκευση αλλαγών" />
    <input id="button2" type="Reset" value="Επαναφορά" />
    <?php if (! isset ( $_GET['ChangePassword'] )): ?>
        <?php if ($this->_tpl_vars['obj']->mAdministrator['administrator_id'] != $this->_tpl_vars['obj']->mMyAdministratorId): ?>
            <input id="button1" type="submit" name="submit_delete_admin" value="Διαγραφή" />
        <?php else: ?>
            <input type="submit" name="submit_delete_admin" value="Διαγραφή" disabled="disabled"/>
        <?php endif; ?>
    <?php endif; ?>
</form>