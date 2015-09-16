<?php /* Smarty version 2.6.22, created on 2015-09-16 21:25:58
         compiled from admin_files.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'admin_files.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'admin_files','assign' => 'obj'), $this);?>

 <div id="box">
  
  
  <form id="form" enctype="multipart/form-data" method="post" action="<?php echo $this->_tpl_vars['obj']->mLinkToFilesAdmin; ?>
">
  
  <fieldset id="image">
  
  <legend>Διαχείριση αρχείων</legend>

  <label>Αρχείο:</label>
    
    <input name="image_file" type="file" value="Μεταφόρτωση" />
    <input id="button1" type="submit" name="submit_upload_file" value="Μεταφόρτωση" />
  
  <br />
  
    </form>
    
    <form id="form" method="post" action="">
        <legend>Αρχεία</legend>

        <table>
          <thead>
           <th>ID</th>
           <th>Αρχείο</th>
           <th>Μέγεθος</th>
           <th>Διαστάσεις</th>
           <th>Link</th>
           <th>Τύπος αρχείου</th>
           <th>Ενέργεια</th>
          </thead>
          <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mFiles) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <td class="a-center"><?php echo $this->_tpl_vars['obj']->mFiles[$this->_sections['i']['index']]['file_id']; ?>
</td>
            <td class="a-center"><?php echo $this->_tpl_vars['obj']->mFiles[$this->_sections['i']['index']]['filename']; ?>
</td>
            <td class="a-center"><?php echo $this->_tpl_vars['obj']->mFiles[$this->_sections['i']['index']]['filesize']; ?>
</td>
            <td class="a-center"><?php echo $this->_tpl_vars['obj']->mFiles[$this->_sections['i']['index']]['imagesize']['3']; ?>
</td>
            <td class="a-center">content/<?php echo $this->_tpl_vars['obj']->mFiles[$this->_sections['i']['index']]['filename']; ?>
</td>
            <td class="a-center"><?php echo $this->_tpl_vars['obj']->mFiles[$this->_sections['i']['index']]['filetype']; ?>
</td>
              <nobr>
              <td class="a-center">
              <input style="width: 100px;" id="button1" type="submit" name="submit_delete_file_<?php echo $this->_tpl_vars['obj']->mFiles[$this->_sections['i']['index']]['file_id']; ?>
"
                value="Διαγραφή" /></nobr>
            </td>
          </tr>
          <?php endfor; endif; ?>
        </table>
        <br><br>
    </form>
</div>