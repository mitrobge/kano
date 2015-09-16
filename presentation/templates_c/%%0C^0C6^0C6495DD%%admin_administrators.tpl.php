<?php /* Smarty version 2.6.22, created on 2015-09-14 22:14:39
         compiled from admin_administrators.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'admin_administrators.tpl', 2, false),array('modifier', 'date_format', 'admin_administrators.tpl', 83, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'admin_administrators','assign' => 'obj'), $this);?>


<?php echo '
<script type="text/javascript">
<!--
function expandMenu(callingElt, elt) {
    var obj = document.getElementById(elt);
    if (obj.style.display == \'none\')
    {
        obj.style.display = \'block\';
    }
    else if (obj.style.display == \'block\')
    {
        obj.style.display = \'none\';
    }
}
//-->
</script>
'; ?>


<br>
<a href="javascript::void(0)" onclick='expandMenu(this, "new_administrator");'>Προσθήκη Διαχειριστή</a>
<br>
<br>

<div id="new_administrator" style="display:none;">
    <?php if ($this->_tpl_vars['obj']->mErrorMessage): ?>
        <p style="color:red">ERROR: <?php echo $this->_tpl_vars['obj']->mErrorMessage; ?>
</p>
        <br>
    <?php endif; ?>
    <form id="form" method="post" action="">
        <fieldset id="add_administrator">
        <legend>Προσθήκη Διαχειριστή</legend>
        <label>Όνομα</label>
        <input type="text" name="admin_first_name" value="<?php echo $this->_tpl_vars['obj']->mNewAdmin['first_name']; ?>
">
        <br />
        <label>Επίθετο</label>
        <input type="text" name="admin_last_name" value="<?php echo $this->_tpl_vars['obj']->mNewAdmin['last_name']; ?>
">
        <br />
        <label>Διεύθυνση Email</label>
        <input type="text" name="admin_email" value="<?php echo $this->_tpl_vars['obj']->mNewAdmin['email']; ?>
">
        <br />
        <label>Κωδικός</label>
        <input type="password" name="admin_password" value="<?php echo $this->_tpl_vars['obj']->mNewAdmin['password']; ?>
">
        <br />
        <label>Επιβεβαίωση Κωδικού</label>
        <input type="password" name="admin_password_confirm" value="<?php echo $this->_tpl_vars['obj']->mNewAdmin['password_confirm']; ?>
">
        <br />
        <p><input id="button1" type="submit" name="submit_add_admin_0" value="Προσθήκη" />
           <input id="button2" type="reset" name="reset" value="Επαναφορά" />
        </p>
        </fieldset>
    </form>
    <br>
</div>

<?php if ($this->_tpl_vars['obj']->mErrorMessage): ?>
    <?php echo '
    <script language=javascript>expandMenu(this, "new_administrator")</script>
    '; ?>

<?php endif; ?>

<div id="box">
    <form id="form" method="post" action="">
        <h3>Διαχειριστές</h3>
        <table width="100%">
            <thead>
                <th width="40">ID</th>
                <th>Όνομα</th>
                <th>Διεύθυνση Email</th>
                <th>Δημιουργήθηκε</th>
                <th>Τελευταία σύνδεση</th>
                <th>Κατάσταση</th>
                <th>&nbsp;</th>
            </thead>
            <tbody>
            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mAdministrators) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <tr>
                <td class="a-center"><?php echo $this->_tpl_vars['obj']->mAdministrators[$this->_sections['i']['index']]['administrator_id']; ?>
</td>
                <td><?php echo $this->_tpl_vars['obj']->mAdministrators[$this->_sections['i']['index']]['last_name']; ?>
 <?php echo $this->_tpl_vars['obj']->mAdministrators[$this->_sections['i']['index']]['first_name']; ?>
</td>
                <td><?php echo $this->_tpl_vars['obj']->mAdministrators[$this->_sections['i']['index']]['email']; ?>
</td>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['obj']->mAdministrators[$this->_sections['i']['index']]['created_on'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y %T") : smarty_modifier_date_format($_tmp, "%d-%m-%Y %T")); ?>
</td>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['obj']->mAdministrators[$this->_sections['i']['index']]['last_login'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y %T") : smarty_modifier_date_format($_tmp, "%d-%m-%Y %T")); ?>
</td>
                <td><?php echo $this->_tpl_vars['obj']->mAdministrators[$this->_sections['i']['index']]['status']; ?>
</td>
                <td class="a-center">
                    <nobr><a href="<?php echo $this->_tpl_vars['obj']->mAdministrators[$this->_sections['i']['index']]['link_to_administrator_details']; ?>
">Λεπτομέρειες</a>
                    <?php if ($this->_tpl_vars['obj']->mAdministrators[$this->_sections['i']['index']]['administrator_id'] != $this->_tpl_vars['obj']->mMyAdministratorId): ?>
                        <input style="width: 100px;" id="button1" type="submit" name="submit_delete_admin_<?php echo $this->_tpl_vars['obj']->mAdministrators[$this->_sections['i']['index']]['administrator_id']; ?>
"
                            value="Διαγραφή" />
                    <?php else: ?>
                        <input style="width: 100px;" type="submit" name="submit_delete_admin_<?php echo $this->_tpl_vars['obj']->mAdministrators[$this->_sections['i']['index']]['administrator_id']; ?>
"
                            value="Διαγραφή" disabled="disabled"/>
                    <?php endif; ?>
                    </nobr>
                </td>
            </tr>
            <?php endfor; endif; ?>
            </tbody>
        </table>
    </form>
</div>