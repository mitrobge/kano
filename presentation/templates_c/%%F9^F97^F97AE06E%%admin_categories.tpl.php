<?php /* Smarty version 2.6.22, created on 2015-09-16 20:45:50
         compiled from admin_categories.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_presentation_object', 'admin_categories.tpl', 2, false),)), $this); ?>
<?php echo smarty_function_load_presentation_object(array('filename' => 'admin_categories','assign' => 'obj'), $this);?>


<?php echo '
<script language="javascript" type="text/javascript">
$(document).ready(function(){
        
    $("input[name^=\\"submit_delete_cat\\"]").click(function(){
        var answer = confirm(\'ΠΡΟΣΟΧΗ: Όλοι οι υποτομείς και όλες οι Έρευνες θα διαγραφούν!\');
        return answer // answer is a boolean
    })
})
</script>
'; ?>


<form id="form" enctype="multipart/form-data" method="post" action="<?php echo $this->_tpl_vars['obj']->mLinkToCategoriesAdmin; ?>
">
    <?php if (isset ( $_GET['Page'] ) && $_GET['Page'] == 'Subcategories'): ?>
        <h3>
           Τμήμα: "<?php if ($this->_tpl_vars['obj']->mCategory['parent_name'] != null): ?><?php echo $this->_tpl_vars['obj']->mCategory['parent_name']; ?>
>><?php endif; ?><?php echo $this->_tpl_vars['obj']->mCategory['name']; ?>
"
                &nbsp;(<a href="<?php echo $this->_tpl_vars['obj']->mLinkToSubcategoriesBack; ?>
">Πίσω</a>)
        </h3>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['obj']->mErrorMessage): ?>
        <p style="color:red"><font size="2"><?php echo $this->_tpl_vars['obj']->mErrorMessage; ?>
</font></p>
        <br />
    <?php endif; ?>
    <br>
    
    
    <fieldset id="admin_add_category">
    <legend>Προσθήκη νέου τμήματος</legend>
    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mLanguages) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <label><?php if ($this->_sections['i']['first']): ?>Όνομα<?php endif; ?></label>
        <input type="text" name="added_category_name_<?php echo $this->_tpl_vars['obj']->mLanguages[$this->_sections['i']['index']]['language_id']; ?>
" value="" size="30" />
        <?php if (count ( $this->_tpl_vars['obj']->mLanguages ) > 1): ?> 
            <img src="images/<?php echo $this->_tpl_vars['obj']->mLanguages[$this->_sections['i']['index']]['language_flag']; ?>
" alt="<?php echo $this->_tpl_vars['obj']->mLanguages[$this->_sections['i']['index']]['language_name']; ?>
" width="15" height="15" border="0">
        <?php endif; ?>
        <br>
    <?php endfor; endif; ?>
    <input id="button1" type="submit" name="submit_add_cat_<?php if (isset ( $_GET['CategoryId'] )): ?><?php echo $_GET['CategoryId']; ?>
<?php else: ?>0<?php endif; ?>" value="Προσθήκη"/>
    </fieldset>
    

    <?php if (count ( $this->_tpl_vars['obj']->mCategories ) == 0): ?>
        <p><b>Κανένα θέμα διαθέσιμο!</b></p>
    <?php else: ?>
        <fieldset id="admin_categories">
        <?php if (! isset ( $_GET['Page'] ) || $_GET['Page'] == 'Categories'): ?>
            <legend>Τομείς</legend>
        <?php elseif ($_GET['Page'] == 'Subcategories'): ?>
            <legend>Τμήματα</legend>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th width="500"></th>
                    <th width="100"></th>
                    <th width="50"></th>
                </tr>
            </thead>
            <tbody>
            
            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mCategories) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    <?php if ($this->_tpl_vars['obj']->mEditItem == $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['category_id']): ?>

                        <tr>
                            <td>
                                <table>
                                <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['obj']->mLanguages) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
                                <tr><b>Όνομα: </b></tr>
                                    <tr>
                                    <input type="text" size=50 name="category_name_<?php echo $this->_tpl_vars['obj']->mLanguages[$this->_sections['j']['index']]['language_id']; ?>
" 
                                        value="<?php echo $this->_tpl_vars['obj']->GetCategoryName($this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['category_id'],$this->_tpl_vars['obj']->mLanguages[$this->_sections['j']['index']]['language_id']); ?>
" size="25" />
                                    </br>
                                    <?php if (count ( $this->_tpl_vars['obj']->mLanguages ) > 1): ?> 
                                        <img src="images/<?php echo $this->_tpl_vars['obj']->mLanguages[$this->_sections['j']['index']]['language_flag']; ?>
" alt="<?php echo $this->_tpl_vars['obj']->mLanguages[$this->_sections['j']['index']]['language_name']; ?>
" width="15" height="15" border="0">
                                    <?php endif; ?>
                                    </tr>
                                    </br>
                                    <tr><b>Περιγραφή: </b></tr>
                                    <tr>
                                      <?php echo '<textarea class="ckeditor" name="category_description_'; ?><?php echo $this->_tpl_vars['obj']->mLanguages[$this->_sections['j']['index']]['language_id']; ?><?php echo '">'; ?><?php echo $this->_tpl_vars['obj']->GetCategoryDetails($this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['category_id'],$this->_tpl_vars['obj']->mLanguages[$this->_sections['j']['index']]['language_id']); ?><?php echo '</textarea>'; ?>

                                    </tr>
                                    </br>
                                    </br>
                                <?php endfor; endif; ?>
                                </table>
                                                            </td>
                            <td>
                            <input id="button1" type="submit" name="submit_update_cat_<?php echo $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['category_id']; ?>
"
                                value="Ενημέρωση" />
                            <input id="button2" type="reset" name="reset" value="Επαναφορά πεδίου" />
                            <input id="button2" type="submit" name="cancel" value="Άκυρο" />
                            </td>
                            <td>
                            <a href="<?php echo $this->_tpl_vars['obj']->SubcategoriesLink($this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['category_id']); ?>
"><font size="2"><b>Υποκατηγορίες</b></font></a>
                            <a href="<?php echo $this->_tpl_vars['obj']->ProductsLink($this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['category_id']); ?>
"><font size="2"><b>Έρευνες</b></font></a>
                            </td>
                        </tr>
                <?php else: ?>
                    <tr>
                        <td>
                        <b><font size="2px"><?php echo $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['name']; ?>
</font></b>
                        </td>
                        <td>
                        <input id="button1" type="submit" name="submit_edit_cat_<?php echo $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['category_id']; ?>
" 
                            value="Επεξεργασία" />
                        <input id="button1" type="submit" name="submit_delete_cat_<?php echo $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['category_id']; ?>
"
                            value="Διαγραφή" />
                        </td>
                        <td> 
                            <a href="<?php echo $this->_tpl_vars['obj']->SubcategoriesLink($this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['category_id']); ?>
"><font size="2"><b>Υποκατηγορίες</b></font></a>
                            <a href="<?php echo $this->_tpl_vars['obj']->ProductsLink($this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['category_id']); ?>
"><font size="2"><b>Έρευνες</b></font></a>
                            <?php if (! isset ( $_GET['Page'] ) || $_GET['Page'] == 'Categories'): ?>
                                <br><a href="<?php echo $this->_tpl_vars['obj']->mCategories[$this->_sections['i']['index']]['link_to_sort']; ?>
"><font size="2"><b>Ταξινόμηση</b></font></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                
            <?php endfor; endif; ?>
            </tbody>
         </table>
        </fieldset>
    <?php endif; ?>
</form>