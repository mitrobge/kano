<?php /* Smarty version 2.6.22, created on 2015-09-16 20:16:28
         compiled from admin_surveys.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'admin_surveys.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'admin_surveys','assign' => 'obj'), $this);?>


<?php echo '
<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    $(\'#SortingTable\').tableDnD({
        onDrop: function(table, row) {
            var data;
            $.getJSON("json/sort_category_children.php", 
                $.tableDnD.serialize(), function(j){
            })
        }
    });
})
</script>
'; ?>


<div id="box">
    <h3>
    Υπηρεσίες του τμήματος "<?php echo $this->_tpl_vars['obj']->mCategoryName; ?>
"
    </h3>
    <br>
    <a href="<?php echo $this->_tpl_vars['obj']->mLinkToCategories; ?>
">Πίσω</a>
    <br>
    <br>
    <h3>
    <a href="<?php echo $this->_tpl_vars['obj']->mLinkToAddProduct; ?>
">Προσθήκη νέας υπηρεσίας</a>
    </h3>
    <br>
    <br>
    <?php if (count ( $this->_tpl_vars['obj']->mProducts ) == 0): ?>
        <p><b>Δεν υπάρχουν πιστοποιήσεις σε αυτόν το τμήμα</b></p>
    <?php else: ?>
        <?php if (count ( $this->_tpl_vars['obj']->mProductsPages ) > 0): ?>
            <?php if ($this->_tpl_vars['obj']->mLinkToPreviousPage): ?>
                <a href="<?php echo $this->_tpl_vars['obj']->mLinkToPreviousPage; ?>
">Προηγούμενη Σελίδα</a>
            <?php endif; ?>
            <?php unset($this->_sections['m']);
$this->_sections['m']['name'] = 'm';
$this->_sections['m']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mProductsPages) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['m']['show'] = true;
$this->_sections['m']['max'] = $this->_sections['m']['loop'];
$this->_sections['m']['step'] = 1;
$this->_sections['m']['start'] = $this->_sections['m']['step'] > 0 ? 0 : $this->_sections['m']['loop']-1;
if ($this->_sections['m']['show']) {
    $this->_sections['m']['total'] = $this->_sections['m']['loop'];
    if ($this->_sections['m']['total'] == 0)
        $this->_sections['m']['show'] = false;
} else
    $this->_sections['m']['total'] = 0;
if ($this->_sections['m']['show']):

            for ($this->_sections['m']['index'] = $this->_sections['m']['start'], $this->_sections['m']['iteration'] = 1;
                 $this->_sections['m']['iteration'] <= $this->_sections['m']['total'];
                 $this->_sections['m']['index'] += $this->_sections['m']['step'], $this->_sections['m']['iteration']++):
$this->_sections['m']['rownum'] = $this->_sections['m']['iteration'];
$this->_sections['m']['index_prev'] = $this->_sections['m']['index'] - $this->_sections['m']['step'];
$this->_sections['m']['index_next'] = $this->_sections['m']['index'] + $this->_sections['m']['step'];
$this->_sections['m']['first']      = ($this->_sections['m']['iteration'] == 1);
$this->_sections['m']['last']       = ($this->_sections['m']['iteration'] == $this->_sections['m']['total']);
?>
                <?php if ($this->_tpl_vars['obj']->mPageNo == $this->_sections['m']['index_next']): ?>
                    <strong><?php echo $this->_sections['m']['index_next']; ?>
</strong>
                <?php else: ?>
                    <a href="<?php echo $this->_tpl_vars['obj']->mProductsPages[$this->_sections['m']['index']]; ?>
"><?php echo $this->_sections['m']['index_next']; ?>
</a>
                <?php endif; ?>
            <?php endfor; endif; ?>
            <?php if ($this->_tpl_vars['obj']->mLinkToNextPage): ?>
                <a href="<?php echo $this->_tpl_vars['obj']->mLinkToNextPage; ?>
">Επόμενη Σελίδα</a>
            <?php endif; ?>
            <br>
            <br>
        <?php endif; ?>
        <table class="tbl_repeat" id="SortingTable">
            <thead>
                <th>Τίτλος</th>
                <th>&nbsp;</th>
            </thead>
            <tbody>
                <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mProducts) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                <tr id="<?php echo $this->_tpl_vars['obj']->mProducts[$this->_sections['i']['index']]['survey_id']; ?>
 1">
                    <td><?php echo $this->_tpl_vars['obj']->mProducts[$this->_sections['i']['index']]['name']; ?>
</td>
                                        <td><a href="<?php echo $this->_tpl_vars['obj']->ProductDetailsLink($this->_tpl_vars['obj']->mProducts[$this->_sections['i']['index']]['survey_id'],1,null); ?>
">Λεπτομέρειες</a></td>
                </tr>
                <?php endfor; endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>